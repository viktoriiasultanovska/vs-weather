<?php

namespace Vs\Weather\Test\Unit\Model\Service\WeatherReport;

use Magento\Framework\TestFramework\Unit\BaseTestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Vs\Weather\Api\Data\ReportInterface;
use Vs\Weather\Model\Service\WeatherReport\ApiDataHydrationException;
use Vs\Weather\Model\Service\WeatherReport\ServiceResponseToReportDbEntityHydrator;

/**
 * Class ServiceResponseToReportDbEntityHydratorTest
 * @package Vs\Weather\Test\Unit\Model\Service\WeatherReport
 */
class ServiceResponseToReportDbEntityHydratorTest extends BaseTestCase
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var ServiceResponseToReportDbEntityHydrator | MockObject */
    protected $hydrator;

    /** @var ReportInterface | MockObject */
    private $report;

    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->report = $this->basicMock(ReportInterface::class);
        $this->hydrator = $this->objectManager->getObject(
            ServiceResponseToReportDbEntityHydrator::class,
            []
        );
        parent::setUp();
    }

    /**
     * @dataProvider unAppropriateApiResponse
     *
     * @param $data
     */
    public function testHydrateAppropriateDataNotFoundInResponse($data): void
    {
        $this->report->expects($this->never())
            ->method('setTemperature');
        $this->report->expects($this->never())
            ->method('setPressure');
        $this->report->expects($this->never())
            ->method('setHumidity');
        $this->report->expects($this->never())
            ->method('setCity');
        $this->expectException(ApiDataHydrationException::class);
        $this->hydrator->hydrate($this->report, $data);
    }

    public function testHydrateAppropriateResponse(): void
    {
        $data = [
            'main' =>
                [
                    'temp'     => 291.15,
                    'pressure' => 1018,
                    'humidity' => 82,
                ],
            'id'   => 765876,
            'name' => 'Lublin',
        ];
        $this->report->expects($this->once())
            ->method('setTemperature')
            ->willReturnSelf();
        $this->report->expects($this->once())
            ->method('setPressure')
            ->willReturnSelf();
        $this->report->expects($this->once())
            ->method('setHumidity')
            ->willReturnSelf();
        $this->report->expects($this->once())
            ->method('setCity')
            ->willReturnSelf();
        $this->assertEquals(
            $this->report,
            $this->hydrator->hydrate($this->report, $data)
        );
    }

    public function unAppropriateApiResponse(): array
    {
        return [
            'response_main_info_block_absent' => [
                'data' => [
                    'id'   => 765876,
                    'name' => 'Lublin',
                ]
            ],
            'response_city_absent'            => [
                'data' => [
                    'main' =>
                        [
                            'temp'     => 291.15,
                            'pressure' => 1018,
                            'humidity' => 82,
                        ],
                    'id'   => 765876,
                ]
            ],
            'response_temperature_absent'     => [
                'data' => [
                    'main' =>
                        [
                            'pressure' => 1018,
                            'humidity' => 82,
                        ],
                    'id'   => 765876,
                    'name' => 'Lublin',
                ]
            ]
        ];
    }
}
