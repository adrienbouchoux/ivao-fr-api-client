# IVAO France API client

[![Build Status](https://travis-ci.org/adrienbouchoux/ivao-fr-api-client.svg?branch=master)](https://travis-ci.org/adrienbouchoux/ivao-fr-api-client)

## Requirements
This package is compatible all PHP versions from 5.4.0, `hhvm` and `nightly`.

Your PHP installation should have `hash` and `curl` extensions activated
(which is the case on default installations).

## Installation
### Using `composer`
You simply need to add the dependency to `composer`:
```console
composer require ivao-fr/api
```
The namespace will be automatically resolved by PSR-4 specification.

### Without `composer`
- If you have `git` installed, clone this repository:
    ```console
    cd your/project/path
    mkdir -p vendor/ivao-fr
    cd vendor/ivao-fr
    git clone https://github.com/adrienbouchoux/ivao-fr-api-client.git
    ```

- If you don't have `git` or you cannot execute commands, you may
[download the archive](https://github.com/adrienbouchoux/ivao-fr-api-client/archive/master.zip)
then extract it into your server.

Require the `load.php` PHP file in the script intended to use
the API client.

```php
require_once 'path/to/load.php';
```

## Using the API Client
Get a response from the API server is straightforward:
```php
try {
    $client = new \IvaoFr\ApiClient\ApiClient(
        'id',                       // your API access ID
        'secret',                   // your secret key
        'http://atcs.ivao.fr/api'
    );
    $data = $client->request('trainer/vid/123456');
    
    /* The response object is already converted from json */
    $trainer = $data->trainer;
    $students = $trainer->students;
} catch (\IvaoFr\ApiClient\ApiException $exception) {
    die($exception->getMessage());
    /*
        Handling the error...
    */
}
```

## Security advice
- Avoid storing your access ID and secret key on hosted repositories.
Basically, you should limit the number of copies of your credentials by
storing them in an include file or in a environment variable.