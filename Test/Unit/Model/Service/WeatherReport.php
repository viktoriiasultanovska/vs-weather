<?php

namespace Vs\Weather\Test\Unit\Model\Service;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;
use Magento\Framework\TestFramework\Unit\BaseTestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Psr\Log\LoggerInterface;
use Vs\Weather\Api\Data\ReportInterface;
use Vs\Weather\ApiClient\ClientInterface;
use Vs\Weather\Model\ReportFactory;
use Vs\Weather\Model\ReportRepository;
use Vs\Weather\Model\Service\WeatherReport;
use Vs\Weather\Model\Service\WeatherReport\ServiceResponseToReportDbEntityHydrator;

/**
 * /**
 * Class WeatherReportManagementTest
 * @package Vs\Weather\Test\Unit\Model
 */
class WeatherReportManagementTest extends BaseTestCase
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var WeatherReport | MockObject */
    protected $service;

    /** @var ClientInterface | MockObject */
    private $apiClient;

    /** @var ServiceResponseToReportDbEntityHydrator | MockObject */
    private $hydrator;

    /** @var JsonSerializer */
    private $jsonSerializer;

    /** @var ReportFactory | MockObject */
    private $reportFactory;

    /** @var ReportInterface | MockObject */
    private $report;

    /** @var ReportInterface | MockObject */
    private $reportHydrated;

    /** @var ReportRepository | MockObject */
    private $reportRepository;

    /** @var LoggerInterface */
    private $logger;

    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->apiClient = $this->basicMock(ClientInterface::class);
        $this->jsonSerializer = $this->basicMock(JsonSerializer::class);
        $this->hydrator
            = $this->basicMock(ServiceResponseToReportDbEntityHydrator::class);
        $this->report = $this->basicMock(ReportInterface::class);
        $this->reportHydrated = $this->basicMock(ReportInterface::class);
        $this->reportFactory = $this->basicMock(ReportFactory::class);
        $this->reportRepository = $this->basicMock(ReportRepository::class);
        $this->logger = $this->basicMock(LoggerInterface::class);
        $this->service = $this->objectManager->getObject(
            WeatherReport::class,
            [
                'apiClient'        => $this->apiClient,
                'jsonSerializer'   => $this->jsonSerializer,
                'hydrator'         => $this->hydrator,
                'reportFactory'    => $this->reportFactory,
                'reportRepository' => $this->reportRepository,
                'logger'           => $this->logger
            ]
        );
        parent::setUp();
    }

    public function testPullWeatherDataFromApiToDBSuccess(): void
    {
        $apiResponse = $this->mockApiResponseJSON();
        $data = json_decode($apiResponse, true);

        $this->apiClient->expects($this->once())->method('call')
            ->willReturn($apiResponse);
        $this->jsonSerializer->expects($this->once())
            ->method('unserialize')
            ->willReturn($data);
        $this->reportFactory->expects($this->once())->method('create')
            ->willReturn($this->report);
        $this->hydrator->expects($this->once())
            ->method('hydrate')
            ->with($this->report, $data)
            ->willReturn($this->reportHydrated);
        $this->reportRepository->expects($this->once())
            ->method('save')
            ->with($this->reportHydrated);
        $this->service->pullWeatherDataFromApiToDB();
    }

    public function testPullWeatherDataFromApiToDBApiCallFail(): void
    {
        $this->apiClient->expects($this->once())->method('call')
            ->willThrowException(new \Exception());

        $this->jsonSerializer->expects($this->never())
            ->method('unserialize');
        $this->reportFactory->expects($this->never())->method('create')
            ->willReturn($this->report);
        $this->hydrator->expects($this->never())
            ->method('hydrate');
        $this->reportRepository->expects($this->never())
            ->method('save');
        $this->logger->expects($this->once())->method('error');

        $this->service->pullWeatherDataFromApiToDB();
    }

    public function testPullWeatherDataFromApiToDBSaveToBDFail(): void
    {
        $apiResponse = $this->mockApiResponseJSON();
        $data = json_decode($apiResponse, true);

        $this->apiClient->expects($this->once())->method('call')
            ->willReturn($apiResponse);
        $this->jsonSerializer->expects($this->once())
            ->method('unserialize')
            ->willReturn($data);
        $this->reportFactory->expects($this->once())->method('create')
            ->willReturn($this->report);
        $this->hydrator->expects($this->once())
            ->method('hydrate')
            ->with($this->report, $data)
            ->willReturn($this->reportHydrated);
        $this->reportRepository->expects($this->once())
            ->method('save')
            ->willThrowException(new \Exception());
        $this->logger->expects($this->once())->method('error');

        $this->service->pullWeatherDataFromApiToDB();
    }

    public function testPullWeatherDataFromApiToDBUnserializeFail(): void
    {
        $apiResponse = $this->mockApiResponseJSON();
        $data = json_decode($apiResponse, true);

        $this->apiClient->expects($this->once())->method('call')
            ->willReturn($apiResponse);
        $this->jsonSerializer->expects($this->once())
            ->method('unserialize')
            ->willThrowException(new \InvalidArgumentException());
        $this->reportFactory->expects($this->never())->method('create')
            ->willReturn($this->report);
        $this->hydrator->expects($this->never())
            ->method('hydrate');
        $this->reportRepository->expects($this->never())
            ->method('save');
        $this->logger->expects($this->once())->method('error');

        $this->service->pullWeatherDataFromApiToDB();
    }

    protected function mockApiResponseJSON()
    {
        return '{"main":{"temp":291.15,"pressure":1018,"humidity":82},"id":765876,"name":"Lublin"}';
    }
}
