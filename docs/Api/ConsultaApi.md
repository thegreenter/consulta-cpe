# Greenter\Sunat\ConsultaCpe\Api\ConsultaApi

All URIs are relative to *https://api-seguridad.sunat.gob.pe/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**consultarCpe**](ConsultaApi.md#consultarCpe) | **POST** /contribuyente/contribuyentes/{ruc}/validarcomprobante | Consulta de comprobante



## consultarCpe

> \Greenter\Sunat\ConsultaCpe\Model\CpeResponse consultarCpe($ruc, $cpe_filter)

Consulta de comprobante

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer authorization: sunat_auth
$config = \Greenter\Sunat\ConsultaCpe\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new \Greenter\Sunat\ConsultaCpe\Api\ConsultaApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$ruc = 'ruc_example'; // string | RUC de quién realiza la consulta
$cpe_filter = new \Greenter\Sunat\ConsultaCpe\Model\CpeFilter(); 

try {
    $result = $apiInstance->consultarCpe($ruc, $cpe_filter);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ConsultaApi->consultarCpe: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **ruc** | **string**| RUC de quién realiza la consulta |
 **cpe_filter** | [**\Greenter\Sunat\ConsultaCpe\Model\CpeFilter**](../Model/CpeFilter.md)|  | [optional]

### Return type

[**\Greenter\Sunat\ConsultaCpe\Model\CpeResponse**](../Model/CpeResponse.md)

### HTTP request headers

- **Content-Type**: application/json
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints)
[[Back to Model list]](../../README.md#documentation-for-models)
[[Back to README]](../../README.md)

