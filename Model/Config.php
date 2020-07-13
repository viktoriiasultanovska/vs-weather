<?php

namespace Vs\Weather\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 * @package Vs\Weather\Model
 */
class Config
{
    private const XML_PATH_WEATHER_API_ENABLED = 'vs_weather_reporting/configuration/enabled';
    private const XML_PATH_WEATHER_API_URL = 'vs_weather_reporting/configuration/vs_service_url';
    private const XML_PATH_WEATHER_API_TOKEN = 'vs_weather_reporting/configuration/token';
    private const XML_PATH_WEATHER_API_UNITS = 'vs_weather_reporting/configuration/units';
    private const XML_PATH_WEATHER_API_CITY = 'vs_weather_reporting/configuration/city';

    /** @var ScopeConfigInterface */
    protected $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param $websiteCode
     *
     * @return bool
     */
    public function isWeatherApiEnabled($websiteCode = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            static::XML_PATH_WEATHER_API_ENABLED,
            ScopeInterface::SCOPE_WEBSITE,
            $websiteCode
        );
    }

    /**
     * @param $websiteCode
     *
     * @return string
     */
    public function getWeatherApiUrl($websiteCode = null): string
    {
        return $this->scopeConfig->getValue(
            static::XML_PATH_WEATHER_API_URL,
            ScopeInterface::SCOPE_WEBSITE,
            $websiteCode
        );
    }

    /**
     * @param $websiteCode
     *
     * @return string
     */
    public function getWeatherApiToken($websiteCode = null): string
    {
        return $this->scopeConfig->getValue(
            static::XML_PATH_WEATHER_API_TOKEN,
            ScopeInterface::SCOPE_WEBSITE,
            $websiteCode
        );
    }

    /**
     * @param $websiteCode
     *
     * @return string
     */
    public function getWeatherApiUnits($websiteCode = null): string
    {
        return $this->scopeConfig->getValue(
            static::XML_PATH_WEATHER_API_UNITS,
            ScopeInterface::SCOPE_WEBSITE,
            $websiteCode
        );
    }

    /**
     * @param $websiteCode
     *
     * @return string
     */
    public function getWeatherApiCity($websiteCode = null): string
    {
        return $this->scopeConfig->getValue(
            static::XML_PATH_WEATHER_API_CITY,
            ScopeInterface::SCOPE_WEBSITE,
            $websiteCode
        );
    }
}
