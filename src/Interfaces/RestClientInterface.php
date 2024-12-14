<?php

namespace Rockberpro\RestClient\Interfaces;

/**
 * @author Samuel Oberger Rockenbach
 * @version 1.0
 * @since october-2024
 */
interface RestClientInterface
{
    public static function build();
    public function url(string $url);
    public function addHeader(string $header);
    public function payload(array $data);
    public function get();
    public function post();
    public function put();
    public function patch();
    public function delete();
}