<?php

namespace Vs\Weather\ApiClient;

/**
 * Interface ClientInterface
 * @package Vs\Weather\ApiClient
 */
interface ClientInterface
{
    /**
     * @param string $path
     * @param string $outputPath
     * @param string $rawBody
     * @param string $contentType
     *
     * @return mixed
     *
     * @throws ApiException
     */
    public function call(
        $path,
        $outputPath = '',
        $rawBody = '',
        $contentType = 'application/json'
    );

}
