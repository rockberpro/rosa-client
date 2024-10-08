<?php

namespace Rockberpro\RestClient;

use Rockberpro\RestClient\Interfaces\CurlServiceInterace;

/**
 * @author Samuel Oberger Rockenbach
 * @version 1.0
 * @since october-2024
 */
class CurlService extends AbstractCurlService implements CurlServiceInterace
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';

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
    public function url(string $url)
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
        return $this->call(CurlService::GET);
    }

    /**
     * @method post
     * @return object HttpReponse
     */
    public function post()
    {
        return $this->call(CurlService::POST);
    }

    /**
     * @method delete
     * @return object HttpReponse
     */
    public function delete()
    {
        return $this->call(CurlService::DELETE);
    }

    /**
     * @method put
     * @return object HttpReponse
     */
    public function put()
    {
        return $this->call(CurlService::PUT);
    }

    /**
     * @method patch
     * @return object HttpReponse
     */
    public function patch()
    {
        return $this->call(CurlService::PATCH);
    }
}