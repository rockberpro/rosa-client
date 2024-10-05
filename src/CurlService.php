<?php

namespace Rosa\Client;

use CurlHandle;
use Throwable;
use RuntimeException;

/**
 * @author Samuel Oberger Rockenbach
 * @version 1.0
 * @since october-2024
 */
class CurlService
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';

    private string $url;

    private CurlHandle $curl;  

    private string $apiKey;
    private string $json;
    private string $keyPath;
    private string $certPath;

    /**
     * Set the Request URL
     * 
     * * allows chaining
     * @example
     *  CurlService::url(<url>)
     *             ->apiKey(<api-key>)
     *             ->build()
     *             ->get()
     * @example
     *  CurlService::url(<url>)
     *             ->apiKey(<api-key>)
     *             ->json(<json>)
     *             ->build()
     *             ->post()
     * 
     * @method build
     * @return self
     */
    public static function url(string $url)
    {
        $instance = new self();
        $instance->setUrl($url);

        return $instance;
    }

    /**
     * Set the API Key
     * 
     * * allows chaining
     * 
     * @method apiKey
     * @param string $apiKey
     * @return self
     */
    public function apiKey(string $apiKey)
    {
        $this->setApiKey($apiKey);

        return $this;
    }

    public function json(string $json)
    {
        $this->setJson($json);

        return $this;
    }

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
     * Builds the Request
     * * ends the chaining
     * 
     * @method build
     * @return self
     */
    public function build()
    {
        $this->initCurl();

        return $this;
    }

    /**
     * @method get
     * @return object HttpReponse
     */
    public function get()
    {
        return $this->executeCall(CurlService::GET);
    }

    /**
     * @method post
     * @return object HttpReponse
     */
    public function post()
    {
        return $this->executeCall(CurlService::POST);
    }

    /**
     * @method delete
     * @return object HttpReponse
     */
    public function delete()
    {
        return $this->executeCall(CurlService::DELETE);
    }
    /**
     * @method put
     * @return object HttpReponse
     */
    public function put()
    {
        return $this->executeCall(CurlService::PUT);
    }
    /**
     * @method patch
     * @return object HttpReponse
     */
    public function patch()
    {
        return $this->executeCall(CurlService::PATCH);
    }

    /**
     * Exec a HTTP call
     * 
     * @method executeCall
     * @return object HttpReponse
     * @throws Exception
     */
    private function executeCall(string $method)
    {
        if(!$this->getCurl()) {
            throw new RuntimeException("Curl not initialized");
        }

        try
        {
            switch ($method) {
                case CurlService::GET:
                    curl_setopt($this->getCurl(), CURLOPT_CUSTOMREQUEST,  CurlService::GET);
                    break;
                case CurlService::POST:
                    curl_setopt($this->getCurl(), CURLOPT_CUSTOMREQUEST, CurlService::POST);
                    break;
                case CurlService::PUT:
                    curl_setopt($this->getCurl(), CURLOPT_CUSTOMREQUEST, CurlService::PUT);
                    break;
                case CurlService::DELETE:
                    curl_setopt($this->getCurl(), CURLOPT_CUSTOMREQUEST,  CurlService::DELETE);
                    break;
                case CurlService::PATCH:
                    curl_setopt($this->getCurl(), CURLOPT_CUSTOMREQUEST,  CurlService::PATCH);
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
    private function initCurl()
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
    private function initCertificate()
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

        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSLCERT, $this->getCertPath());
        curl_setopt($curl, CURLOPT_SSLKEY, $this->getKeyPath());
        curl_setopt($curl, CURLOPT_SSLCERTTYPE, "PEM");

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);

        if ($this->getJson()) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getJson());
        }

        return $this->setCurl($curl);
    }

    /**
     * @method closeCurl
     * @return void
     */
    private function closeCurl()
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
    private function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @method setApiKey
     * @param string $apiKey
     * @return self
     */
    private function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @method setJson
     * @return void
     */
    private function setJson(string $json)
    {
        $this->json = $json;
    }

    /**
     * @method getJson
     * @return string json
     */
    private function getJson()
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
    private function getCertPath()
    {
        return $this->certPath ?? '';
    }

    /**
     * @method setCertPath
     * @return self
     * @throws RuntimeException
     */ 
    private function setCertPath(string $certPath)
    {
        if(!is_file($certPath)) {
            throw new RuntimeException("Certificate note found: invalid path");
        }
        $this->certPath = $certPath;

        return $this;
    }
}