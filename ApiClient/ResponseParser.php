<?php

namespace Vs\Weather\ApiClient;

use Zend\Http\Response;

/**
 * Class ResponseParser
 * @package Vs\Weather\ApiClient\Client\Http
 */
class ResponseParser
{
    /**
     * @param Response $response
     *
     * @return string
     *
     * @throws ApiException
     */
    public function parseCasualResponse(Response $response): string
    {
        $status = $response->getStatusCode();
        if ($status !== 200
            && false === empty(ApiException::KNOWN_ERRORS[$status])
        ) {
            throw new ApiException(__(ApiException::KNOWN_ERRORS[$status]));
        }

        return $response->getBody();
    }

}
