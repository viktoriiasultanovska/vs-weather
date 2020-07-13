<?php

namespace Vs\Weather\ViewModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Vs\Weather\Model\Config;
use Vs\Weather\Model\Config\Source\City as CitySourse;
use Vs\Weather\Model\Report\ReportEntityToReportDataItemConverter;
use Vs\Weather\Model\WeatherReportManagement;
use Vs\Weather\Util\WeatherReportDataItemInterface;

/**
 * Class WeatherReport
 * @package Vs\Weather\ViewModel
 */
class WeatherReport implements ArgumentInterface
{
    /** @var WeatherReportManagement */
    private $weatherReportManagement;

    /** @var Config */
    private $config;
    /**
     * @var ReportEntityToReportDataItemConverter
     */
    private $dataItemConverter;

    /**
     * WeatherReport constructor.
     *
     * @param WeatherReportManagement $weatherReportManagement
     * @param ReportEntityToReportDataItemConverter $dataItemConverter
     * @param Config $config
     */
    public function __construct(
        WeatherReportManagement $weatherReportManagement,
        ReportEntityToReportDataItemConverter $dataItemConverter,
        Config $config
    ) {
        $this->weatherReportManagement = $weatherReportManagement;
        $this->config = $config;
        $this->dataItemConverter = $dataItemConverter;
    }

    /**
     * @return bool|WeatherReportDataItemInterface
     */
    public function getLatestWeatherReport()
    {
        if (!CitySourse::WEATHER_API_CITY_OPTIONS[$this->config->getWeatherApiCity()]) {
            return false;
        }
        try {
            return $this->dataItemConverter->convert(
                $this->weatherReportManagement
                    ->getLatestCityWeatherReport(
                        CitySourse::WEATHER_API_CITY_OPTIONS[$this->config->getWeatherApiCity()]
                    )
            );
        } catch (LocalizedException $exception) {
            return false;
        }
    }
}
