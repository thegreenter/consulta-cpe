<?php declare(strict_types=1);

namespace Greenter\Sunat\ConsultaCpe\Api;

use Greenter\Sunat\ConsultaCpe\Model\ApiToken;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\MultipartStream;
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
 * AuthApi Class
 */
class AuthApi
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
     * Operation getToken
     *
     * Generar un nuevo token
     *
     * @param  string $grant_type grant_type (required)
     * @param  string $scope scope (required)
     * @param  string $client_id client_id generado en menú sol (required)
     * @param  string $client_secret client_secret generado en menú sol (required)
     *
     * @return ApiToken
     * @throws InvalidArgumentException|ApiException
     */
    public function getToken($grant_type, $scope, $client_id, $client_secret)
    {
        list($response) = $this->getTokenWithHttpInfo($grant_type, $scope, $client_id, $client_secret);
        return $response;
    }

    /**
     * Operation getTokenWithHttpInfo
     *
     * Generar un nuevo token
     *
     * @param  string $grant_type (required)
     * @param  string $scope (required)
     * @param  string $client_id client_id generado en menú sol (required)
     * @param  string $client_secret client_secret generado en menú sol (required)
     *
     * @throws ApiException on non-2xx response
     * @throws InvalidArgumentException
     *
     * @return ApiToken[]
     */
    public function getTokenWithHttpInfo($grant_type, $scope, $client_id, $client_secret)
    {
        $request = $this->getTokenRequest($grant_type, $scope, $client_id, $client_secret);

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
                    if ('\Greenter\Sunat\ConsultaCpe\Model\ApiToken' === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = (string) $responseBody;
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\Greenter\Sunat\ConsultaCpe\Model\ApiToken', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\Greenter\Sunat\ConsultaCpe\Model\ApiToken';
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
                        '\Greenter\Sunat\ConsultaCpe\Model\ApiToken',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation getTokenAsync
     *
     * Generar un nuevo token
     *
     * @param  string $grant_type (required)
     * @param  string $scope (required)
     * @param  string $client_id client_id generado en menú sol (required)
     * @param  string $client_secret client_secret generado en menú sol (required)
     *
     * @throws InvalidArgumentException
     * @return PromiseInterface
     */
    public function getTokenAsync($grant_type, $scope, $client_id, $client_secret)
    {
        return $this->getTokenAsyncWithHttpInfo($grant_type, $scope, $client_id, $client_secret)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation getTokenAsyncWithHttpInfo
     *
     * Generar un nuevo token
     *
     * @param  string $grant_type (required)
     * @param  string $scope (required)
     * @param  string $client_id client_id generado en menú sol (required)
     * @param  string $client_secret client_secret generado en menú sol (required)
     *
     * @throws InvalidArgumentException
     * @return PromiseInterface
     */
    public function getTokenAsyncWithHttpInfo($grant_type, $scope, $client_id, $client_secret)
    {
        $returnType = '\Greenter\Sunat\ConsultaCpe\Model\ApiToken';
        $request = $this->getTokenRequest($grant_type, $scope, $client_id, $client_secret);

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
     * Create request for operation 'getToken'
     *
     * @param  string $grant_type (required)
     * @param  string $scope (required)
     * @param  string $client_id client_id generado en menú sol (required)
     * @param  string $client_secret client_secret generado en menú sol (required)
     *
     * @throws InvalidArgumentException
     * @return Request
     */
    protected function getTokenRequest($grant_type, $scope, $client_id, $client_secret)
    {
        // verify the required parameter 'client_id' is set
        if ($client_id === null || (is_array($client_id) && count($client_id) === 0)) {
            throw new InvalidArgumentException(
                'Missing the required parameter $client_id when calling getToken'
            );
        }
        // verify the required parameter 'grant_type' is set
        if ($grant_type === null || (is_array($grant_type) && count($grant_type) === 0)) {
            throw new InvalidArgumentException(
                'Missing the required parameter $grant_type when calling getToken'
            );
        }
        // verify the required parameter 'scope' is set
        if ($scope === null || (is_array($scope) && count($scope) === 0)) {
            throw new InvalidArgumentException(
                'Missing the required parameter $scope when calling getToken'
            );
        }
        // verify the required parameter 'client_id' is set
        if ($client_id === null || (is_array($client_id) && count($client_id) === 0)) {
            throw new InvalidArgumentException(
                'Missing the required parameter $client_id when calling getToken'
            );
        }
        // verify the required parameter 'client_secret' is set
        if ($client_secret === null || (is_array($client_secret) && count($client_secret) === 0)) {
            throw new InvalidArgumentException(
                'Missing the required parameter $client_secret when calling getToken'
            );
        }

        $resourcePath = '/clientesextranet/{client_id}/oauth2/token/';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($client_id !== null) {
            $resourcePath = str_replace(
                '{' . 'client_id' . '}',
                ObjectSerializer::toPathValue($client_id),
                $resourcePath
            );
        }

        // form params
        if ($grant_type !== null) {
            $formParams['grant_type'] = ObjectSerializer::toFormValue($grant_type);
        }
        // form params
        if ($scope !== null) {
            $formParams['scope'] = ObjectSerializer::toFormValue($scope);
        }
        // form params
        if ($client_id !== null) {
            $formParams['client_id'] = ObjectSerializer::toFormValue($client_id);
        }
        // form params
        if ($client_secret !== null) {
            $formParams['client_secret'] = ObjectSerializer::toFormValue($client_secret);
        }
        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                ['application/x-www-form-urlencoded']
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
                $httpBody = Query::build($formParams);
            }
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
