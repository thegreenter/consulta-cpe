# Consulta Integrada CPE

![CI](https://github.com/thegreenter/consulta-cpe/workflows/CI/badge.svg)

PHP Client para API de [CONSULTA INTEGRADA DE COMPROBANTE DE PAGO](https://cdn.www.gob.pe/uploads/document/file/536289/Manual_de_Consulta_Integrada_de_Validez_de_CdP_por_Servicio_WEB.pdf) expuesta por SUNAT. 

## Requerimientos

- PHP 7.1 o posterior
- `curl` extension habilitado.

## Instalación

Utilizando [Composer](http://getcomposer.org/):

```bash
composer require greenter/consulta-cpe
```

## Uso

Primero es necesario obtener el `client_id`, `client_secret` desde el portal de SUNAT, puedes seguir la [guía oficial](https://orientacion.sunat.gob.pe/images/imagenes/contenido/comprobantes/Manual-de-Consulta-Integrada-de-Comprobante-de-Pago-por-ServicioWEB.pdf).

1. Solicitud de token.

```php
<?php

$apiInstance = new \Greenter\Sunat\ConsultaCpe\Api\AuthApi(
    new \GuzzleHttp\Client()
);

$grant_type = 'client_credentials'; // Constante
$scope = 'https://api.sunat.gob.pe/v1/contribuyente/contribuyentes'; // Constante
$client_id = 'client_id_example'; // client_id generado en menú sol
$client_secret = 'client_secret_example'; // client_secret generado en menú sol

try {
    $result = $apiInstance->getToken($grant_type, $scope, $client_id, $client_secret);
        
    echo 'Token: '.$result->getAccessToken().PHP_EOL;
    echo 'Expira: '.$result->getExpiresIn().' segundos'.PHP_EOL;
} catch (Exception $e) {
    echo 'Excepcion cuando invocaba AuthApi->getToken: ', $e->getMessage(), PHP_EOL;
}
```

> No necesitas solicitar un token por cada consulta, puedes usar el mismo durante el tiempo de expiración, generalmente 3600 seg (1h).

2. Consulta de CPE.

```php
<?php

// Token generado en el ejemplo anterior
$token = 'xxxxxxxx';

$config = \Greenter\Sunat\ConsultaCpe\Configuration::getDefaultConfiguration()->setAccessToken($token);

$apiInstance = new \Greenter\Sunat\ConsultaCpe\Api\ConsultaApi(
    new GuzzleHttp\Client(),
    $config->setHost($config->getHostFromSettings(1))
);
$ruc = '20000000001'; // RUC de quién realiza la consulta
$cpeFilter = (new \Greenter\Sunat\ConsultaCpe\Model\CpeFilter())
            ->setNumRuc($ruc)
            ->setCodComp('01') // Tipo de comprobante
            ->setNumeroSerie('F001')
            ->setNumero('1')
            ->setFechaEmision('20/10/2020')
            ->setMonto('100.00');

try {
    $result = $apiInstance->consultarCpe($ruc, $cpeFilter);
    if (!$result->getSuccess()) {
        echo $result->getMessage();
        return;
    }

    $data = $result->getData();
    switch ($data->getEstadoCp()) {
        case '0': echo 'NO EXISTE'; break;
        case '1': echo 'ACEPTADO'; break;
        case '2': echo 'ANULADO'; break;
        case '3': echo 'AUTORIZADO'; break;
        case '4': echo 'NO AUTORIZADO'; break;
    }

    echo PHP_EOL.'Estado RUC: '.$data->getEstadoRuc();
    echo PHP_EOL.'Condicion RUC: '.$data->getCondDomiRuc();

} catch (Exception $e) {
    echo 'Excepcion cuando invocaba ConsultaApi->consultarCpe: ', $e->getMessage(), PHP_EOL;
}
```

## Tabla de códigos

Tipo de comprobante

|Código | Descripción                |
|-------|----------------------------|
|01     | Factura                    |
|03     | Boleta de venta            |
|04     | Liquidación de compra      |
|07     | Nota de crédito            |
|08     | Nota de débito             |
|R1     | Recibo por honorarios      |
|R7     | Nota de crédito de recibos |

Estado del comprobante (Códigos devuelto en `$data->getEstadoCp()`)

Código | Descripción                           |
-------|---------------------------------------|
0 | NO EXISTE (Comprobante no informado) |
1 | ACEPTADO (Comprobante aceptado) |
2 | ANULADO (Comunicado en una baja) |
3 | AUTORIZADO (con autorización de imprenta) |
4 | NO AUTORIZADO (no autorizado por imprenta) |
 
Estado del contribuyente (Códigos devuelto en `$data->getEstadoRuc()`)

Código | Descripción                           |
-------|---------------------------------------|
00 | ACTIVO
01 | BAJA PROVISIONAL
02 | BAJA PROV. POR OFICIO
03 | SUSPENSION TEMPORAL
10 | BAJA DEFINITIVA
11 | BAJA DE OFICIO
22 | INHABILITADO-VENT.UNICA

Condición de Domicilio del Contribuyente (Códigos devuelto en `$data->getCondDomiRuc()`)

Código | Descripción                           |
-------|---------------------------------------|
00 | HABIDO
09 | PENDIENTE
11 | POR VERIFICAR
12 | NO HABIDO
20 | NO HALLADO

## Docs Models

 - [ApiToken](docs/Model/ApiToken.md)
 - [CpeFilter](docs/Model/CpeFilter.md)
 - [CpeResponse](docs/Model/CpeResponse.md)
 - [CpeStatus](docs/Model/CpeStatus.md)

