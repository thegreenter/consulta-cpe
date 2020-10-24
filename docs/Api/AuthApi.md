# OpenAPI\Client\AuthApi

All URIs are relative to *https://api-seguridad.sunat.gob.pe/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getToken**](AuthApi.md#getToken) | **POST** /clientesextranet/{client_id}/oauth2/token/ | Generar un nuevo token



## getToken

> \OpenAPI\Client\Model\ApiToken getToken($client_id, $grant_type, $scope, $client_id, $client_secret)

Generar un nuevo token

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


$apiInstance = new OpenAPI\Client\Api\AuthApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$client_id = 'client_id_example'; // string | El client_id generado en menú sol
$grant_type = 'client_credentials'; // string | 
$scope = 'https://api.sunat.gob.pe/v1/contribuyente/contribuyentes'; // string | 
$client_id = 'client_id_example'; // string | client_id generado en menú sol
$client_secret = 'client_secret_example'; // string | client_secret generado en menú sol

try {
    $result = $apiInstance->getToken($client_id, $grant_type, $scope, $client_id, $client_secret);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthApi->getToken: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **client_id** | **string**| El client_id generado en menú sol |
 **grant_type** | **string**|  | [default to &#39;client_credentials&#39;]
 **scope** | **string**|  | [default to &#39;https://api.sunat.gob.pe/v1/contribuyente/contribuyentes&#39;]
 **client_id** | **string**| client_id generado en menú sol |
 **client_secret** | **string**| client_secret generado en menú sol |

### Return type

[**\OpenAPI\Client\Model\ApiToken**](../Model/ApiToken.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/x-www-form-urlencoded
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)

