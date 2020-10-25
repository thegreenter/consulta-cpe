<?php declare(strict_types=1);

namespace Tests\Greenter\Sunat\ConsultaCpe\Api;

use Greenter\Sunat\ConsultaCpe\Api\AuthApi;
use Greenter\Sunat\ConsultaCpe\Api\ConsultaApi;
use Greenter\Sunat\ConsultaCpe\Configuration;
use Greenter\Sunat\ConsultaCpe\Model\CpeFilter;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * ConsultaApiTest
 * @group manual
 */
class ConsultaApiTest extends TestCase
{
    /**
     * Test case for consultarCpe
     *
     * Consulta de comprobante.
     *
     */
    public function testConsultarCpe()
    {
        $client = new Client();
        $apiInstance = new AuthApi($client);

        $result = $apiInstance->getToken(
            'client_credentials',
            'https://api.sunat.gob.pe/v1/contribuyente/contribuyentes',
        'xxxxx-xxx-xxxx-xxxx-xxxxxxxxx',
        'xxxxxxxxxxxxx');
        $token = $result->getAccessToken();

        $config = Configuration::getDefaultConfiguration()
                    ->setAccessToken($token);

        $cpeInstance = new ConsultaApi(
            $client,
            $config->setHost($config->getHostFromSettings(1))
        );

        $ruc = '20123456789';
        $filter = new CpeFilter();
        $filter
            ->setNumRuc($ruc)
            ->setCodComp('01')
            ->setNumeroSerie('E001')
            ->setNumero('5')
            ->setFechaEmision('20/10/2020')
            ->setMonto('100.00');

        $result = $cpeInstance->consultarCpe($ruc, $filter);

        $this->assertTrue($result->getSuccess());

        if (!$result->getSuccess()) {
            echo $result->getMessage();
            return;
        }

        $data = $result->getData();
        switch ($data->getEstadoCp()) {
            case '0': echo 'NO EXISTE'.PHP_EOL; break;
            case '1': echo 'ACEPTADO'.PHP_EOL; break;
            case '2': echo 'ANULADO'.PHP_EOL; break;
            case '3': echo 'AUTORIZADO'.PHP_EOL; break;
            case '4': echo 'NO AUTORIZADO'.PHP_EOL; break;
        }

        echo 'Estado RUC: '.$data->getEstadoRuc().PHP_EOL;
        echo 'Condicion RUC: '.$data->getCondDomiRuc().PHP_EOL;
        echo 'Observaciones: '.join(',',$data->getObservaciones()).PHP_EOL;
    }
}
