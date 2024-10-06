<?php

namespace Rosa\Client\Interfaces;

/**
 * @author Samuel Oberger Rockenbach
 * @version 1.0
 * @since october-2024
 */
interface RestClientInterface
{
    public static function build(string $apiKey);
    public function url(string $url);
    public function apiKey(string $apiKey);
    public function payload(array $data);
    public function get();
    public function post();
    public function put();
    public function patch();
    public function delete();
}