
# Rosa-Client: A REST API Client Built in PHP

## Introduction

**Rosa-Client** is a lightweight and efficient PHP-based REST API client. Its primary purpose is to streamline the process of interacting with RESTful APIs by providing a simple interface for sending HTTP requests and handling responses in a clean and reusable manner. Whether you need to communicate with third-party services or develop your own API interactions, Rosa-Client offers a flexible solution to manage REST API requests and responses.

### Example: Simple Routes

```php
/ ** GET * /
$client =  RestClient::buildForGet();
$client->url('localhost:8080/api/user/1')
	   ->apiKey(DotEnv::get('CLIENT_API_KEY'))
	   ->get()

/ ** POST * /
$client =  RestClient::buildForPost();
$client->url('localhost:8080/api/user/')
	   ->apiKey(DotEnv::get('CLIENT_API_KEY'))
	   ->payload(['id'  =>  '1'])
	   ->post()

/ ** PUT * /
$client =  RestClient::buildForPut();
$client->url('localhost:8080/api/user/')
	   ->apiKey(DotEnv::get('CLIENT_API_KEY'))
	   ->payload(['id'  =>  '2'])
	   ->put();

/ ** PATCH */
$client =  RestClient::buildForPatch();
$client->url('localhost:8081/api/user/')
	   ->apiKey(DotEnv::get('CLIENT_API_KEY'))
       ->payload(['id'  =>  '3'])
       ->patch();

/ ** DELETE * /
$client =  RestClient::buildForDelete();
$client->url('localhost:8081/api/user/1')
	   ->apiKey(DotEnv::get('CLIENT_API_KEY'))
	   ->delete()
```
