<?php

namespace Rockberpro\RestClient\Interfaces;

/**
 * @author Samuel Oberger Rockenbach
 * @version 1.0
 * @since october-2024
 */
interface CurlServiceInterace
{
    public function url(string $url);
    public function addHeader(string $header);
    public function json(string $json);
    public function build();
    public function get();
    public function post();
    public function put();
    public function patch();
    public function delete();
    public function certificate(string $certPath, string $keyPath);
}