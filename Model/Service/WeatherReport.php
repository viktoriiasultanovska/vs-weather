<?php

namespace Vs\Weather\Model\Service;

use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use Psr\Log\LoggerInterface;
use Vs\Weather\ApiClient\ClientInterface;
use Vs\Weather\Model\Api\ApiUrlBuilder;
use Vs\Weather\Model\ReportFactory;
use Vs\Weather\Model\ReportRepository;
use Vs\Weather\Model\Service\WeatherReport\ServiceResponseToReportDbEntityHydrator;

/**
 * Class WeatherReport
 * @package Vs\Weather\Model\Service
 */
class WeatherReport
{
    /** @var ClientInterface */
    private $apiClient;

    /** @var JsonSerializer */
    private $jsonSerializer;

    /** @var ReportFactory */
    private $reportFactory;

    /** @var ReportRepository */
    private $reportRepository;

    /** @var ApiUrlBuilder */
    private $urlBuilder;

    /** @var WeatherReport\ServiceResponseToReportDbEntityHydrator */
    private $hydrator;

    /** @var LoggerInterface */
    private $logger;

    /**
     * WeatherReport constructor.
     *
     * @param ClientInterface $apiClient
     * @param JsonSerializer $jsonSerializer
     * @param ApiUrlBuilder $urlBuilder
     * @param ReportFactory $reportFactory
     * @param ReportRepository $reportRepository
     * @param LoggerInterface $logger
     * @param ServiceResponseToReportDbEntityHydrator $hydrator
     */
    public function __construct(
        ClientInterface $apiClient,
        JsonSerializer $jsonSerializer,
        ApiUrlBuilder $urlBuilder,
        ReportFactory $reportFactory,
        ReportRepository $reportRepository,
        LoggerInterface $logger,
        ServiceResponseToReportDbEntityHydrator $hydrator
    ) {
        $this->apiClient = $apiClient;
        $this->jsonSerializer = $jsonSerializer;
        $this->reportFactory = $reportFactory;
        $this->reportRepository = $reportRepository;
        $this->urlBuilder = $urlBuilder;
        $this->hydrator = $hydrator;
        $this->logger = $logger;
    }

    /**
     * @param null $websiteCode
     */
    public function pullWeatherDataFromApiToDB($websiteCode = null): void
    {
        try {
            $response = $this->apiClient->call(
                $this->urlBuilder->getApiUrl($websiteCode)
            );
            $data = $this->jsonSerializer->unserialize($response);
            $report = $this->hydrator->hydrate(
                $this->reportFactory->create(),
                $data
            );
            $this->reportRepository->save($report);

        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
