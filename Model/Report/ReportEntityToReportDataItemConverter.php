<?php

namespace Vs\Weather\Model\Report;

use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Vs\Weather\Api\Data\ReportInterface;
use Vs\Weather\Model\Config;
use Vs\Weather\Model\Config\Source\Units;
use Vs\Weather\Util\WeatherReportDataItemFactory;
use Vs\Weather\Util\WeatherReportDataItemInterface;

/**
 * Class ReportEntityToReportDataItemConverter
 * Converts ReportInterface to decorated WeatherReportDataItemInterface
 * @package Vs\Weather\Model\Report
 */
class ReportEntityToReportDataItemConverter
{
    const WEATHER_REPORT_DATE_FORMAT = 'd/m/Y g:i A';

    /** @var WeatherReportDataItemFactory */
    private $dataItemFactory;

    /** @var TimezoneInterface */
    private $timezone;

    /** @var Config */
    private $config;

    /**
     * ReportEntityToReportDataItemConverter constructor.
     *
     * @param WeatherReportDataItemFactory $dataItemFactory
     * @param TimezoneInterface $timezone
     * @param Config $config
     */
    public function __construct(
        WeatherReportDataItemFactory $dataItemFactory,
        TimezoneInterface $timezone,
        Config $config
    ) {
        $this->dataItemFactory = $dataItemFactory;
        $this->timezone = $timezone;
        $this->config = $config;
    }

    /**
     * @param ReportInterface $report
     *
     * @return WeatherReportDataItemInterface
     */
    public function convert(
        ReportInterface $report
    ): WeatherReportDataItemInterface {
        $reportDataItem = $this->dataItemFactory->create();
        if (!$report->getId()) {
            return $reportDataItem;
        }
        $reportDataItem->setCity($report->getCity());
        $reportDataItem->setObtainedAt(
            $this->timezone->date($report->getCreatedAt())
                ->format(self::WEATHER_REPORT_DATE_FORMAT)
        );
        $reportDataItem->setTemperature(
            sprintf(
                '%0.1f %s',
                $report->getTemperature(),
                $this->getTemperatureLabel()
            )
        );
        $reportDataItem->setHumidity(
            sprintf("%0.0f %s", $report->getHumidity(), '%')
        );
        $reportDataItem->setPressure(
            sprintf("%0.0f %s", $report->getPressure(), 'hpa')
        );

        return $reportDataItem;
    }

    /**
     * @return string
     */
    protected function getTemperatureLabel(): string
    {
        switch ($this->config->getWeatherApiUnits()) {
            case Units::WEATHER_API_UNIT_IMPERIAL:
                $label = '°F';
                break;
            default:
                $label = '°C';
                break;
        }

        return $label;
    }
}
