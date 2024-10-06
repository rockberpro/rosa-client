<?php

use Rosa\Client\RestClient;
use Rosa\Client\Utils\DotEnv;

require_once "vendor/autoload.php";

DotEnv::load('.env');

/**
 * GET
 */
$client = RestClient::buildForGet();
$response = $client->url('localhost:8081/api/user/1')
    ->apiKey(DotEnv::get('CLIENT_API_KEY'))
    ->get()
;
var_dump($response);

/**
 * POST
 */
$client = RestClient::buildForPost();
$response = $client->url('localhost:8081/api/user/')
    ->apiKey(DotEnv::get('CLIENT_API_KEY'))
    ->payload(['id' => '1'])
    ->post()
;
var_dump($response);

/**
 * PUT
 */
$client = RestClient::buildForPut();
$response = $client->url('localhost:8081/api/user/')
    ->apiKey(DotEnv::get('CLIENT_API_KEY'))
    ->payload(['id' => '2'])
    ->put();
var_dump($response);

/**
 * PATCH
 */
$client = RestClient::buildForPatch();
$response = $client->url('localhost:8081/api/user/')
    ->apiKey(DotEnv::get('CLIENT_API_KEY'))
    ->payload(['id' => '3'])
    ->patch();
var_dump($response);

/**
 * DELETE
 */
$client = RestClient::buildForDelete();
$response = $client->url('localhost:8081/api/user/1')
    ->apiKey(DotEnv::get('CLIENT_API_KEY'))
    ->delete()
;
var_dump($response);