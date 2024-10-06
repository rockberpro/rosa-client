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
    ->apiKey(DotEnv::get('API_ROSA_KEY'))
    ->get()
;
var_dump($response);

/**
 * POST
 */
$client = RestClient::buildForPost();
$response = $client->url('localhost:8081/api/user/')
    ->apiKey(DotEnv::get('API_ROSA_KEY'))
    ->payload(['name' => '1st Name'])
    ->post()
;
var_dump($response);

/**
 * PUT
 */
$client = RestClient::buildForPut();
$response = $client->url('localhost:8081/api/user/')
    ->apiKey(DotEnv::get('API_ROSA_KEY'))
    ->payload(['name' => '2nd Name'])
    ->put();
var_dump($response);

/**
 * PATCH
 */
$client = RestClient::buildForPatch();
$response = $client->url('localhost:8081/api/user/')
    ->apiKey(DotEnv::get('API_ROSA_KEY'))
    ->payload(['name' => '3rd Name'])
    ->patch();
var_dump($response);

/**
 * DELETE
 */
$client = RestClient::buildForDelete();
$response = $client->url('localhost:8081/api/user/1')
    ->apiKey(DotEnv::get('API_ROSA_KEY'))
    ->delete()
;
var_dump($response);