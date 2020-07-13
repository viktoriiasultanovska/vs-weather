<?php

namespace Vs\Weather\Model\Api;

use Vs\Weather\Model\Config;

/**
 * Class ApiUrlBuilder
 * @package Vs\Weather\Model\Api
 */
class ApiUrlBuilder
{
    private const API_PARAM_CITY_ID = 'id';
    private const API_PARAM_TOKEN = 'APPID';
    private const API_PARAM_UNITS = 'units';

    /** @var Config */
    private $config;

    /**
     * ApiUrlBuilder constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param null $websiteCode
     *
     * @return string
     */
    public function getApiUrl($websiteCode = null): string
    {
        $uri = $this->config->getWeatherApiUrl($websiteCode);
        $params = [
            self::API_PARAM_CITY_ID => $this->config->getWeatherApiCity($websiteCode),
            self::API_PARAM_TOKEN => $this->config->getWeatherApiToken(),
            self::API_PARAM_UNITS => $this->config->getWeatherApiUnits($websiteCode)
        ];

        return $this->prepareUri($uri, $params);
    }

    /**
     *
     * @param string $uri
     * @param array $params
     *
     * @return string
     */
    protected function prepareUri($uri, $params = [])
    {
        $urlParts = parse_url($uri);
        $queryData = [];
        if (!empty($urlParts['query'])) {
            parse_str($urlParts['query'], $queryData);
            $queryData = array_merge($queryData, $params);
        } else {
            $queryData = $params;
        }

        $urlParts['path'] = $urlParts['path'] ?? '';
        $query = (!empty($queryData) ? '?' : '') . http_build_query($queryData);

        return implode('', [
            $urlParts['scheme'],
            '://',
            $urlParts['host'],
            !empty($urlParts['port']) && $urlParts['port'] != '80' ? ':' . $urlParts['port'] : '',
            $urlParts['path'],
            $query
        ]);
    }
}
