<?php

namespace Rockberpro\RestClient;

use Rockberpro\RestClient\Interfaces\CurlServiceInterace;

/**
 * 
 * @example
 *  CurlService::url(<url>)
 *             ->addHeader(<header>)
 *             ->build()
 *             ->get()
 * @example
 *  CurlService::url(<url>)
 *             ->addHeader(<header>)
 *             ->json(<json>)
 *             ->build()
 *             ->post()
 * 
 * 
 * @author Samuel Oberger Rockenbach
 * @version 1.0
 * @since october-2024
 * 
 */
class CurlService extends AbstractCurlService implements CurlServiceInterace
{
    const GET   = 'GET';
    const POST  = 'POST';
    const PUT   = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';

    /**
     * Set the Request URL
     * 
     * * allows chaining
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
     * Add a header to the Request
     * 
     * * allows chaining
     * 
     * @method addHeader
     * @param string $header
     * @return self
     */
    public function addHeader(string $header)
    {
        $this->headers[] = $header;

        return $this;
    }

    /**
     * Set the query params
     * 
     * * allows chaining
     * @method query
     * @param array $data
     * @return self
     */
    public function query(array $data)
    {
        $this->setQuery($data);

        return $this;
    }

    /**
     * Set the body of the Request
     * 
     * * allows chaining
     * @method body
     * @param string $json
     * @return self
     */
    public function body(string $json)
    {
        $this->setBody($json);

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