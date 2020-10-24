<?php declare(strict_types=1);

namespace Greenter\Sunat\ConsultaCpe\Api;

use Greenter\Sunat\ConsultaCpe\Model\CpeFilter;
use Greenter\Sunat\ConsultaCpe\Model\CpeResponse;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Greenter\Sunat\ConsultaCpe\ApiException;
use Greenter\Sunat\ConsultaCpe\Configuration;
use Greenter\Sunat\ConsultaCpe\HeaderSelector;
use Greenter\Sunat\ConsultaCpe\ObjectSerializer;
use InvalidArgumentException;
use RuntimeException;

/**
 * ConsultaApi Class
 */
class ConsultaApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @var int Host index
     */
    protected $hostIndex;

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     * @param int             $host_index (Optional) host index to select the list of hosts if defined in the OpenAPI spec
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null,
        $host_index = 0
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
        $this->hostIndex = $host_index;
    }

    /**
     * Set the host index
     *
     * @param int $hostIndex index (required)
     */
    public function setHostIndex(int $hostIndex)
    {
        $this->hostIndex = $hostIndex;
    }

    /**
     * Get the host index
     *
     * @return int
     */
    public function getHostIndex()
    {
        return $this->hostIndex;
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation consultarCpe
     *
     * Consulta de comprobante
     *
     * @param string|null $ruc RUC de quién realiza la consulta (required)
     * @param CpeFilter|null $cpe_filter cpe_filter (optional)
     *
     * @return CpeResponse
     *@throws InvalidArgumentException
     * @throws ApiException on non-2xx response
     */
    public function consultarCpe(?string $ruc, ?CpeFilter $cpe_filter = null)
    {
        list($response) = $this->consultarCpeWithHttpInfo($ruc, $cpe_filter);
        return $response;
    }

    /**
     * Operation consultarCpeWithHttpInfo
     *
     * Consulta de comprobante
     *
     * @param  string|null $ruc RUC de quién realiza la consulta (required)
     * @param  CpeFilter|null $cpe_filter (optional)
     *
     * @return array
     *
     * @throws InvalidArgumentException|ApiException
     */
    public function consultarCpeWithHttpInfo(?string $ruc, ?CpeFilter $cpe_filter = null)
    {
        $request = $this->consultarCpeRequest($ruc, $cpe_filter);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            switch($statusCode) {
                case 200:
                    $content = (string) $responseBody;

                    return [
                        ObjectSerializer::deserialize($content, '\Greenter\Sunat\ConsultaCpe\Model\CpeResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\Greenter\Sunat\ConsultaCpe\Model\CpeResponse';
            $responseBody = $response->getBody();
            $content = (string) $responseBody;

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Greenter\Sunat\ConsultaCpe\Model\CpeResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation consultarCpeAsync
     *
     * Consulta de comprobante
     *
     * @param  string $ruc RUC de quién realiza la consulta (required)
     * @param  CpeFilter $cpe_filter (optional)
     *
     * @throws InvalidArgumentException
     * @return PromiseInterface
     */
    public function consultarCpeAsync($ruc, $cpe_filter = null)
    {
        return $this->consultarCpeAsyncWithHttpInfo($ruc, $cpe_filter)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation consultarCpeAsyncWithHttpInfo
     *
     * Consulta de comprobante
     *
     * @param  string $ruc RUC de quién realiza la consulta (required)
     * @param  CpeFilter $cpe_filter (optional)
     *
     * @throws InvalidArgumentException
     * @return PromiseInterface
     */
    public function consultarCpeAsyncWithHttpInfo($ruc, $cpe_filter = null)
    {
        $returnType = '\Greenter\Sunat\ConsultaCpe\Model\CpeResponse';
        $request = $this->consultarCpeRequest($ruc, $cpe_filter);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    $content = (string) $responseBody;

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'consultarCpe'
     *
     * @param  string|null $ruc RUC de quién realiza la consulta (required)
     * @param  CpeFilter|null $cpe_filter (optional)
     *
     * @throws InvalidArgumentException
     * @return Request
     */
    protected function consultarCpeRequest(?string $ruc, ?CpeFilter $cpe_filter = null)
    {
        // verify the required parameter 'ruc' is set
        if ($ruc === null) {
            throw new InvalidArgumentException(
                'Missing the required parameter $ruc when calling consultarCpe'
            );
        }

        $resourcePath = '/contribuyente/contribuyentes/{ruc}/validarcomprobante';
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';

        // path params
        if ($ruc !== null) {
            $resourcePath = str_replace(
                '{' . 'ruc' . '}',
                ObjectSerializer::toPathValue($ruc),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;
        if (isset($cpe_filter)) {
            $_tempBody = $cpe_filter;
        }

        $headers = $this->headerSelector->selectHeaders(
            ['application/json'],
            ['application/json']
        );

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            if ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($_tempBody));
            } else {
                $httpBody = $_tempBody;
            }
        }

        // this endpoint requires Bearer authentication (access token)
        if ($this->config->getAccessToken() !== null) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = Query::build($queryParams);
        return new Request(
            'POST',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option
     *
     * @throws RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}
