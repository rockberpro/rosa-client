<?php

namespace Rosa\Client\Interfaces;

interface AbstractCurlServiceInterface
{
    public static function url(string $url);
    public function apiKey(string $apiKey);
    public function json(string $json);
    public function build();
    public function get();
    public function post();
    public function put();
    public function patch();
    public function delete();
    public function certificate(string $certPath, string $keyPath);
}