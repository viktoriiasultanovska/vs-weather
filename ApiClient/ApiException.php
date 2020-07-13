<?php

namespace Vs\Weather\ApiClient;

use Magento\Framework\Exception\IntegrationException;

/**
 * Class ApiException
 * @package Vs\Weather\ApiClient
 */
class ApiException extends IntegrationException
{
    const KNOWN_ERRORS = [
        400 => 'Invalid Payload Requested',
        401 => 'Invalid API key',
        403 => 'The requested resource is forbidden',
        413 => 'Request or Response Payload is too large',
        404 => 'Request rejected or service not found',
        405 => 'Request is rejected due to unauthorized HTTP verbs or because of a CORS issue',
        408 => 'Timeout',
        502 => 'Unexpected backend service error',
        500 => 'Unexpected error'
    ];
}
