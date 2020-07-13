<?php

namespace Vs\Weather\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class City
 * @package Vs\Weather\Model\Config\Source
 */
class City implements OptionSourceInterface
{
    // List of city ID city.list.json.gz can be downloaded here http://bulk.openweathermap.org/sample/
    protected const WEATHER_API_CITY_LUBLIN = 765876;
    protected const WEATHER_API_CITY_LONDON = 2643743;

    public const WEATHER_API_CITY_OPTIONS = [
            self::WEATHER_API_CITY_LUBLIN => 'Lublin',
            self::WEATHER_API_CITY_LONDON => 'London'
        ];

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return self::WEATHER_API_CITY_OPTIONS;
    }
}
