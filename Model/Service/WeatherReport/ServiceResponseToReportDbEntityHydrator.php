<?php

namespace Vs\Weather\Model\Service\WeatherReport;

use Magento\Framework\EntityManager\HydratorInterface;
use Magento\Framework\Phrase;

/**
 * Class is used to populate entity with data
 *
 * Class ServiceResponseToReportDbEntityHydrator
 * @package Vs\Weather\Model\Service\WeatherReport
 */
class ServiceResponseToReportDbEntityHydrator implements HydratorInterface
{
    private const API_RESPONSE_MAIN_BLOCK = 'main';
    private const API_RESPONSE_MAIN_BLOCK_TEMPERATURE = 'temp';
    private const API_RESPONSE_MAIN_BLOCK_PRESSURE = 'pressure';
    private const API_RESPONSE_MAIN_BLOCK_HUMIDITY = 'humidity';
    private const API_RESPONSE_CITY_NAME = 'name';

    private const API_RESPONSE_ERROR_MSG = 'Appropriate data not found in the response';

    /**
     * @param object $report
     * @param array $data
     *
     * @return object
     * @throws ApiDataHydrationException
     */
    public function hydrate($report, array $data)
    {
        if (!isset($data[self::API_RESPONSE_MAIN_BLOCK])) {
            throw new ApiDataHydrationException(new Phrase(self::API_RESPONSE_ERROR_MSG));
        }
        if (!isset($data[self::API_RESPONSE_CITY_NAME])) {
            throw new ApiDataHydrationException(new Phrase(self::API_RESPONSE_ERROR_MSG));
        }
        $mainDataBlock = $data[self::API_RESPONSE_MAIN_BLOCK];
        if (!isset($mainDataBlock[self::API_RESPONSE_MAIN_BLOCK_TEMPERATURE])) {
            throw new ApiDataHydrationException(new Phrase(self::API_RESPONSE_ERROR_MSG));
        }
        $temperature = $mainDataBlock[self::API_RESPONSE_MAIN_BLOCK_TEMPERATURE];
        $pressure = $mainDataBlock[self::API_RESPONSE_MAIN_BLOCK_PRESSURE];
        $humidity = $mainDataBlock[self::API_RESPONSE_MAIN_BLOCK_HUMIDITY];
        $city = $data[self::API_RESPONSE_CITY_NAME];

        $report->setTemperature($temperature);
        $report->setPressure($pressure);
        $report->setHumidity($humidity);
        $report->setCity($city);

        return $report;
    }

    public function extract($entity)
    {
    }
}
