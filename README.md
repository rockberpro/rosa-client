
# Rosa-Client: Smart REST client for PHP

## Introduction

**Rosa-Client** is a lightweight and efficient PHP-based REST API client. Its primary purpose is to streamline the process of interacting with RESTful APIs by providing a simple interface for sending HTTP requests and handling responses in a clean and reusable manner. Whether you need to communicate with third-party services or develop your own API interactions, Rosa-Client offers a flexible solution to manage REST API requests and responses.

### Example: Consuming REST Services

```php
DotEnv::load('.env');

/ ** Create client * /
$client = new RestClient();

/ ** GET * /
$client->url('localhost:8080/api/user/1')
       ->addHeader('Authorization: Bearer <token>')
       ->get();

/ ** POST * /
$client->url('localhost:8080/api/user/')
       ->addHeader('Authorization: Bearer <token>')
       ->body(['id'  =>  '1'])
       ->post();

/ ** PUT * /
$client->url('localhost:8080/api/user/')
       ->addHeader('Authorization: Bearer <token>')
       ->body(['id'  =>  '2'])
       ->put();

/ ** PATCH */
$client->url('localhost:8080/api/user/')
       ->addHeader('Authorization: Bearer <token>')
       ->body(['id'  =>  '3'])
       ->patch();

/ ** DELETE */
$client->url('localhost:8080/api/user/1')
       ->addHeader('Authorization: Bearer <token>')
       ->delete();
```
