<?php

namespace Rockberpro\RestClient;

use Rockberpro\RestClient\Interfaces\RestClientInterface;

/**
 * @author Samuel Oberger Rockenbach
 * @version 1.0
 * @since october-2024
 */
class RestClient implements RestClientInterface
{
    private CurlService $curlSerivce;

    public static function build(string $apiKey)
    {
        $instance = new self();
        $instance->curlSerivce = new CurlService();
        $instance->apiKey($apiKey);

        return $instance;
    }

    /**
     * Set the URL
     * 
     * @method url
     * @param string $url
     * @return self
     */
    public function url(string $url)
    {
        $this->curlSerivce->setUrl($url);

        return $this;
    }

    /**
     * Set the API Key
     * 
     * @method apiKey
     * @param string $apiKey
     * @return self
     */
    public function apiKey(string $apiKey)
    {
        $this->curlSerivce->apiKey($apiKey);

        return $this;
    }

    /**
     * Set the payload
     * 
     * @method payload
     * @param array $data
     * @return self
     */
    public function payload(array $data)
    {
        $this->curlSerivce->json(json_encode($data));

        return $this;
    }

    /**
     * Execute a GET request
     * 
     * @method get
     * @return mixed
     */
    public function get()
    {
        $this->curlSerivce->build();
        return $this->curlSerivce->get();
    }

    /**
     * Execute a POST request
     * 
     * @method post
     * @return mixed
     */
    public function post()
    {
        $this->curlSerivce->build();
        return $this->curlSerivce->post();
    }

    /**
     * Execute a PUT request
     * 
     * @method put
     * @return mixed
     */
    public function put()
    {
        $this->curlSerivce->build();
        return $this->curlSerivce->put();
    }

    /**
     * Execute a PATCH request
     * 
     * @method patch
     * @return mixed
     */
    public function patch()
    {
        $this->curlSerivce->build();
        return $this->curlSerivce->patch();
    }

    /**
     * Execute a DELETE request
     * 
     * @method delete
     * @return mixed
     */
    public function delete()
    {
        $this->curlSerivce->build();
        return $this->curlSerivce->delete();
    }
}