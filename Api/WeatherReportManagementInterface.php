<?php

namespace Vs\Weather\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Vs\Weather\Api\Data\ReportInterface;

/**
 * Interface WeatherReportManagementInterface
 * @package Vs\Weather\Api
 */
interface WeatherReportManagementInterface
{
    /**
     * @param string $city
     * @throws NoSuchEntityException
     *
     * @return ReportInterface | false
     */
    public function getLatestCityWeatherReport(string $city): ReportInterface;
}
