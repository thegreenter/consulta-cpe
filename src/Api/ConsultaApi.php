<?php declare(strict_types=1);

namespace Greenter\Sunat\ConsultaCpe\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Greenter\Sunat\ConsultaCpe\ApiException;
use Greenter\Sunat\ConsultaCpe\Configuration;
use Greenter\Sunat\ConsultaCpe\HeaderSelector;
use Greenter\Sunat\ConsultaCpe\ObjectSerializer;

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
     * @param  int Host index (required)
     */
    public function setHostIndex($host_index)
    {
        $this->hostIndex = $host_index;
    }

    /**
     * Get the host index
     *
     * @return Host index
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
     * @param  string $ruc RUC de quién realiza la consulta (required)
     * @param  \Greenter\Sunat\ConsultaCpe\Model\CpeFilter $cpe_filter cpe_filter (optional)
     *
     * @throws \Greenter\Sunat\ConsultaCpe\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Greenter\Sunat\ConsultaCpe\Model\CpeResponse
     */
    public function consultarCpe($ruc, $cpe_filter = null)
    {
        list($response) = $this->consultarCpeWithHttpInfo($ruc, $cpe_filter);
        return $response;
    }

    /**
     * Operation consultarCpeWithHttpInfo
     *
     * Consulta de comprobante
     *
     * @param  string $ruc RUC de quién realiza la consulta (required)
     * @param  \Greenter\Sunat\ConsultaCpe\Model\CpeFilter $cpe_filter (optional)
     *
     * @throws \Greenter\Sunat\ConsultaCpe\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Greenter\Sunat\ConsultaCpe\Model\CpeResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function consultarCpeWithHttpInfo($ruc, $cpe_filter = null)
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
                    if ('\Greenter\Sunat\ConsultaCpe\Model\CpeResponse' === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = (string) $responseBody;
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\Greenter\Sunat\ConsultaCpe\Model\CpeResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\Greenter\Sunat\ConsultaCpe\Model\CpeResponse';
            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = (string) $responseBody;
            }

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
     * @param  \Greenter\Sunat\ConsultaCpe\Model\CpeFilter $cpe_filter (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
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
     * @param  \Greenter\Sunat\ConsultaCpe\Model\CpeFilter $cpe_filter (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
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
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = (string) $responseBody;
                    }

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
     * @param  string $ruc RUC de quién realiza la consulta (required)
     * @param  \Greenter\Sunat\ConsultaCpe\Model\CpeFilter $cpe_filter (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function consultarCpeRequest($ruc, $cpe_filter = null)
    {
        // verify the required parameter 'ruc' is set
        if ($ruc === null || (is_array($ruc) && count($ruc) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $ruc when calling consultarCpe'
            );
        }

        $resourcePath = '/contribuyente/contribuyentes/{ruc}/validarcomprobante';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



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

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                ['application/json']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            if ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($_tempBody));
            } else {
                $httpBody = $_tempBody;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
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

        $query = \GuzzleHttp\Psr7\build_query($queryParams);
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
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}
