# Consulta Integrada CPE

CONSULTA INTEGRADA DE COMPROBANTE DE PAGO.

## Requirements

PHP 7.1 and later

## Installation & Usage

### Composer

To install this package via [Composer](http://getcomposer.org/):

```bash
composer require greenter/consulta-cpe
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new \Greenter\Sunat\ConsultaCpe\Api\AuthApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new \GuzzleHttp\Client()
);

$grant_type = 'client_credentials'; // string | 
$scope = 'https://api.sunat.gob.pe/v1/contribuyente/contribuyentes'; // string | 
$client_id = 'client_id_example'; // string | client_id generado en menú sol
$client_secret = 'client_secret_example'; // string | client_secret generado en menú sol

try {
    $result = $apiInstance->getToken($grant_type, $scope, $client_id, $client_secret);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthApi->getToken: ', $e->getMessage(), PHP_EOL;
}

?>
```

## Documentation for API Endpoints

All URIs are relative to *https://api-seguridad.sunat.gob.pe/v1*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*AuthApi* | [**getToken**](docs/Api/AuthApi.md#gettoken) | **POST** /clientesextranet/{client_id}/oauth2/token/ | Generar un nuevo token
*ConsultaApi* | [**consultarCpe**](docs/Api/ConsultaApi.md#consultarcpe) | **POST** /contribuyente/contribuyentes/{ruc}/validarcomprobante | Consulta de comprobante


## Documentation For Models

 - [ApiToken](docs/Model/ApiToken.md)
 - [CpeFilter](docs/Model/CpeFilter.md)
 - [CpeResponse](docs/Model/CpeResponse.md)
 - [CpeStatus](docs/Model/CpeStatus.md)

