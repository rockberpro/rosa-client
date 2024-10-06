<?php

namespace Rosa\Client;

use Rosa\Client\Interfaces\AbstractCurlServiceInterface;

use CurlHandle;
use RuntimeException;
use Throwable;

abstract class AbstractCurlService implements AbstractCurlServiceInterface
{
    protected string $url;

    protected CurlHandle $curl;  

    protected string $apiKey;
    protected string $json;
    protected string $keyPath;
    protected string $certPath;

    /**
     * Load certificate 
     * 
     * @method certificate
     * @param string $certPath
     * @param string $keyPath 
     * @return self
     * @throws RuntimeException
     */
    public function certificate(
        string $certPath,
        string $keyPath
    )
    {
        try 
        {
            $this->setCertPath($certPath);
            $this->setKeyPath($keyPath);
            $this->initCertificate();
        }
        catch(Throwable $e)
        {
            throw new RuntimeException($e->getMessage());
        }

        $this->initCertificate();

        return $this;
    }

    /**
     * Execute a HTTP call
     * 
     * @method call
     * @return object HttpReponse
     * @throws Exception
     */
    protected function call(string $method)
    {
        if(!$this->getCurl()) {
            throw new RuntimeException("Curl not initialized");
        }

        try
        {
            switch ($method) {
                case CurlService::GET:
                    curl_setopt($this->getCurl(), CURLOPT_CUSTOMREQUEST, CurlService::GET);
                    break;
                case CurlService::POST:
                    curl_setopt($this->getCurl(), CURLOPT_CUSTOMREQUEST, CurlService::POST);
                    break;
                case CurlService::PUT:
                    curl_setopt($this->getCurl(), CURLOPT_CUSTOMREQUEST, CurlService::PUT);
                    break;
                case CurlService::DELETE:
                    curl_setopt($this->getCurl(), CURLOPT_CUSTOMREQUEST, CurlService::DELETE);
                    break;
                case CurlService::PATCH:
                    curl_setopt($this->getCurl(), CURLOPT_CUSTOMREQUEST, CurlService::PATCH);
                    break;
                default:
                    throw new RuntimeException('Invalid HTTP metohd');
                break;
            }

            $response = curl_exec($this->getCurl());
            $statusCode = curl_getinfo($this->getCurl(), CURLINFO_HTTP_CODE);
        }
        catch(Throwable $e)
        {
            throw new RuntimeException($e->getMessage());
        }

        if (curl_errno($this->getCurl())) {
            throw new RuntimeException('Curl error: ' . curl_error($this->getCurl()));
        }

        $this->closeCurl();

        return new class($response, $statusCode)
        {
            public $response;
            public $status;
            public function __construct($response, $statusCode)
            {
                $this->response = $response;
                $this->status = $statusCode;

                return $this;
            }
        };
    }

    /**
     * @method initCurl
     * @return CurlHandle
     */
    protected function initCurl()
    {
        $curl = null;
        $curl = curl_init();
        if(!$curl) {
            throw new RuntimeException("Error initializing Curl");
        }
        curl_setopt($curl, CURLOPT_URL, $this->getUrl());

        $headers[] = "Content-Type: application/json";
        if ($this->getApiKey()) {
            $headers[] = "X-Api-Key: {$this->getApiKey()}";
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($this->getJson()) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getJson());
        }

        return $this->setCurl($curl);
    }

    /**
     * @method initCertificate
     * @return CurlHandle
     */
    protected function initCertificate()
    {
        $curl = null;
        $curl = curl_init();
        if(!$curl) {
            throw new RuntimeException("Error initializing Curl");
        }
        curl_setopt($curl, CURLOPT_URL, $this->getUrl());

        $headers[] = "Content-Type: application/json";
        if ($this->getApiKey()) {
            $headers[] = "X-Api-Key: {$this->getApiKey()}";
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_SSLCERT, $this->getCertPath());
        curl_setopt($curl, CURLOPT_SSLKEY, $this->getKeyPath());
        curl_setopt($curl, CURLOPT_SSLCERTTYPE, "PEM");

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));

        if ($this->getJson()) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getJson());
        }

        return $this->setCurl($curl);
    }

    /**
     * @method closeCurl
     * @return void
     */
    protected function closeCurl()
    {
        curl_close($this->curl);
    }

        /**
     * @method getUrl
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @method setUrl
     * @return  self
     */ 
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @method getCurl
     * @return CurlHandle
     */
    public function getCurl()
    {
        return $this->curl;
    }

    /**
     * @method setCurl
     * @return  self
     */ 
    public function setCurl($curl)
    {
        $this->curl = $curl;

        return $this;
    }

    /**
     * @method getApiKey
     * @return string
     */
    protected function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @method setApiKey
     * @param string $apiKey
     * @return self
     */
    protected function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @method setJson
     * @return void
     */
    protected function setJson(string $json)
    {
        $this->json = $json;
    }

    /**
     * @method getJson
     * @return string json
     */
    protected function getJson()
    {
        return $this->json ?? '';
    }

    /**
     * @method getKeyPath
     * @return string
     */
    public function getKeyPath()
    {
        return $this->keyPath ?? '';
    }

    /**
     * @method setKeyPath
     * @return  self
     * @throws RuntimeException
     */ 
    public function setKeyPath(string $keyPath)
    {
        if(!is_file($keyPath)) {
            throw new RuntimeException("Key not found: invalid path");
        }
        $this->keyPath = $keyPath;

        return $this;
    }

    /**
     * @method getCertPath
     * @return string
     */
    protected function getCertPath()
    {
        return $this->certPath ?? '';
    }

    /**
     * @method setCertPath
     * @return self
     * @throws RuntimeException
     */ 
    protected function setCertPath(string $certPath)
    {
        if(!is_file($certPath)) {
            throw new RuntimeException("Certificate note found: invalid path");
        }
        $this->certPath = $certPath;

        return $this;
    }
}