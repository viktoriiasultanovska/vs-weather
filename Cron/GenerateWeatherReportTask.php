<?php

namespace Vs\Weather\Cron;

use Magento\Cron\Model\Schedule;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Vs\Weather\Model\Config;
use Vs\Weather\Model\Service\WeatherReport;

/**
 * Class GenerateWeatherReportTask
 * @package Vs\Weather\Cron
 */
class GenerateWeatherReportTask
{
    const CRON_TASK_WEATHER_REPORT_GENERATION_STARTED = 'CRON Task: Weather Report generation started';
    const CRON_TASK_WEATHER_REPORT_GENERATION_COMPLETED = 'CRON Task: Weather Report generation completed';
    const CRON_TASK_WEATHER_REPORT_DISABLED = 'CRON Task: Weather Report generation disabled on website %s';

    /** @var LoggerInterface */
    private $logger;

    /** @var StoreManagerInterface */
    private $storeManager;

    /** @var WeatherReport */
    private $weatherReport;

    /** @var Config */
    private $config;

    /**
     * GenerateWeatherReportTask constructor.
     *
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param WeatherReport $weatherReport
     * @param Config $config
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        WeatherReport $weatherReport,
        Config $config
    ) {
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->weatherReport = $weatherReport;
        $this->config = $config;
    }

    /**
     * @param Schedule $schedule
     *
     * @return $this
     */
    public function execute(Schedule $schedule): self
    {
        $this->logger->debug(self::CRON_TASK_WEATHER_REPORT_GENERATION_STARTED);
        foreach ($this->storeManager->getWebsites() as $website) {
            if ($this->config->isWeatherApiEnabled($website)) {
                $this->pullWeatherDataFromApiToDB($website);
            } else {
                $this->logger->debug(
                    sprintf(
                        self::CRON_TASK_WEATHER_REPORT_DISABLED,
                        $website->getCode()
                    )
                );
            }
        }
        $this->logger->debug(self::CRON_TASK_WEATHER_REPORT_GENERATION_COMPLETED);

        return $this;
    }

    /**
     * @param $website
     *
     * @return string
     */
    public function pullWeatherDataFromApiToDB($website): ?string
    {
        try {
            $this->weatherReport->pullWeatherDataFromApiToDB($website->getCode());
        } catch (\Exception $e) {
            $this->logger->debug(
                sprintf(
                    'CRON Task: Error: %s',
                    $e->getMessage()
                )
            );

            return $e->getMessage();
        }
    }
}
