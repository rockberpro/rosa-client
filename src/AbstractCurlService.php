<?php

namespace Rockberpro\RestClient;

use Rockberpro\RestClient\Interfaces\AbstractCurlServiceInterface;

use RuntimeException;
use Throwable;

/**
 * @author Samuel Oberger Rockenbach
 * @version 1.0
 * @since october-2024
 */
abstract class AbstractCurlService implements AbstractCurlServiceInterface
{
    protected string $url;

    protected $curl;

    protected array $headers;
    protected array $query;
    protected string $body;
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
     * @return resource
     */
    protected function initCurl()
    {
        $curl = null;
        $curl = curl_init();
        if(!$curl) {
            throw new RuntimeException("Error initializing Curl");
        }

        if ($this->getQuery()) {
            $this->setUrl($this->getUrl() . '?' . http_build_query($this->getQuery(),'', '&'));
        }
        curl_setopt($curl, CURLOPT_URL, $this->getUrl());

        $this->headers[] = "Content-Type: application/json";
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($this->getBody()) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getBody());
        }

        return $this->setCurl($curl);
    }

    /**
     * @method initCertificate
     * @return resource
     */
    protected function initCertificate()
    {
        $curl = null;
        $curl = curl_init();
        if(!$curl) {
            throw new RuntimeException("Error initializing Curl");
        }

        if ($this->getQuery()) {
            $this->setUrl($this->getUrl() . '?' . http_build_query($this->getQuery(),'', '&'));
        }
        curl_setopt($curl, CURLOPT_URL, $this->getUrl());

        $this->headers[] = "Content-Type: application/json";
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_SSLCERT, $this->getCertPath());
        curl_setopt($curl, CURLOPT_SSLKEY, $this->getKeyPath());
        curl_setopt($curl, CURLOPT_SSLCERTTYPE, "PEM");

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));

        if ($this->getBody()) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getBody());
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
     * @return resource
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
     * @method getAuthorization
     * @return string
     */
    protected function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @method setAuthorization
     * @param string $authorization
     * @return self
     */
    protected function setAuthorization(string $authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * @method setQuery
     * @param array $data
     * @return void
     */
    protected function setQuery(array $data)
    {
        $this->query = $data;
    }

    /**
     * @method getQuery
     * @return array
     */
    protected function getQuery()
    {
        return $this->query ?? [];
    }

    /**
     * @method setJson
     * @param string $json
     * @return void
     */
    protected function setBody(string $json)
    {
        $this->body = $json;
    }

    /**
     * @method getBody
     * @param string $json
     * @return string json
     */
    protected function getBody()
    {
        return $this->body ?? '';
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