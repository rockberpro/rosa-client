<?php

namespace Rosa\Client;

use Rosa\Client\Interfaces\RestClientInterface;

/**
 * @author Samuel Oberger Rockenbach
 * @version 1.0
 * @since october-2024
 */
abstract class AbstractRestClient implements RestClientInterface
{
    /**
     * @method buildForGet
     */
    public static function buildForGet()
    {
        return new class
        {
            private CurlService $curlSerivce;

            public function __construct()
            {
                $this->curlSerivce = new CurlService();
            }

            public function url(string $url)
            {
                $this->curlSerivce->setUrl($url);

                return $this;
            }

            public function apiKey(string $apiKey)
            {
                $this->curlSerivce->apiKey($apiKey);

                return $this;
            }

            public function get()
            {
                $this->curlSerivce->build();
                return $this->curlSerivce->get();
            }
        };
    }

    /**
     * @method buildForPost
     */
    public static function buildForPost()
    {
        return new class
        {
            private CurlService $curlSerivce;

            public function __construct()
            {
                $this->curlSerivce = new CurlService();
            }

            public function url(string $url)
            {
                $this->curlSerivce->setUrl($url);

                return $this;
            }

            public function apiKey(string $apiKey)
            {
                $this->curlSerivce->apiKey($apiKey);

                return $this;
            }

            public function payload(array $data)
            {
                $this->curlSerivce->json(json_encode($data));

                return $this;
            }

            public function post()
            {
                $this->curlSerivce->build();
                return $this->curlSerivce->post();
            }
        };
    }

    /**
     * @method buildForPut
     */
    public static function buildForPut()
    {
        return new class
        {
            private CurlService $curlSerivce;

            public function __construct()
            {
                $this->curlSerivce = new CurlService();
            }

            public function url(string $url)
            {
                $this->curlSerivce->setUrl($url);

                return $this;
            }

            public function apiKey(string $apiKey)
            {
                $this->curlSerivce->apiKey($apiKey);

                return $this;
            }

            public function payload(array $data)
            {
                $this->curlSerivce->json(json_encode($data));

                return $this;
            }

            public function put()
            {
                $this->curlSerivce->build();
                return $this->curlSerivce->put();
            }
        };
    }

    /**
     * @method buildForPatch
     */
    public static function buildForPatch()
    {
        return new class
        {
            private CurlService $curlSerivce;

            public function __construct()
            {
                $this->curlSerivce = new CurlService();
            }

            public function url(string $url)
            {
                $this->curlSerivce->setUrl($url);

                return $this;
            }

            public function apiKey(string $apiKey)
            {
                $this->curlSerivce->apiKey($apiKey);

                return $this;
            }

            public function payload(array $data)
            {
                $this->curlSerivce->json(json_encode($data));

                return $this;
            }

            public function patch()
            {
                $this->curlSerivce->build();
                return $this->curlSerivce->patch();
            }
        };
    }

    /**
     * @method buildForDelete
     */
    public static function buildForDelete()
    {
        return new class
        {
            private CurlService $curlSerivce;

            public function __construct()
            {
                $this->curlSerivce = new CurlService();
            }

            public function url(string $url)
            {
                $this->curlSerivce->setUrl($url);

                return $this;
            }

            public function apiKey(string $apiKey)
            {
                $this->curlSerivce->apiKey($apiKey);

                return $this;
            }

            public function delete()
            {
                $this->curlSerivce->build();
                return $this->curlSerivce->delete();
            }
        };
    }
}