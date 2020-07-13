<?php

namespace Vs\Weather\ApiClient;

use Zend\Http\Client\Adapter\Curl;
use Zend\Http\Request;

/**
 * Class Client
 * @package Vs\Weather\ApiClient
 */
class Client extends \Zend\Http\Client implements ClientInterface
{
    /** @var ResponseParser */
    protected $responseParser;

    /**
     * Client constructor.
     *
     * @param ResponseParser $responseParser
     * @param null $uri
     * @param null $options
     */
    public function __construct(
        ResponseParser $responseParser,
        $uri = null,
        $options = null
    ) {
        parent::__construct($uri, $options);
        $this->responseParser = $responseParser;
    }

    /**
     * @inheritdoc
     */
    public function call(
        $path,
        $outputPath = '',
        $rawBody = '',
        $contentType = 'application/json'
    ) {
        $this->prepareClient(Request::METHOD_GET);
        $this->setUri($path);
        $headers = [
            'Content-Type' => $contentType
        ];
        $this->setHeaders($headers);
        if (!empty($rawBody)) {
            $this->setRawBody($rawBody);
        }
        if (!empty($outputPath)) {
            $this->setOptions(['outputstream' => $outputPath]);
        }

        $response = $this->send();

        return $this->responseParser->parseCasualResponse($response);
    }

    /**
     * @param string $method
     */
    private function prepareClient($method = Request::METHOD_POST): void
    {
        $this->reset();
        $this->setAdapter(Curl::class);
        $this->setOptions(['outputstream' => false]);
        $this->setMethod($method);
    }
}
