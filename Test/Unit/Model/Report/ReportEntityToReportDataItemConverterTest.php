<?php

namespace Vs\Weather\Test\Unit\Model\Report;

use DateTime;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\TestFramework\Unit\BaseTestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Vs\Weather\Api\Data\ReportInterface;
use Vs\Weather\Model\Report\ReportEntityToReportDataItemConverter;
use Vs\Weather\Util\WeatherReportDataItem;
use Vs\Weather\Util\WeatherReportDataItemFactory;

/**
 * Class ReportEntityToReportDataItemConverterTest
 * @package Vs\Weather\Test\Unit\Model\Report
 */
class ReportEntityToReportDataItemConverterTest extends BaseTestCase
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var ReportEntityToReportDataItemConverter | MockObject */
    protected $converter;

    /** @var WeatherReportDataItemFactory | MockObject */
    private $dataItemFactory;

    /** @var WeatherReportDataItem | MockObject */
    private $dataItem;

    /** @var ReportInterface | MockObject */
    private $report;

    /** @var TimezoneInterface | MockObject */
    private $timezone;

    /** @var DateTime | MockObject */
    private $dateTime;


    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->dataItemFactory
            = $this->basicMock(WeatherReportDataItemFactory::class);
        $this->dataItem
            = $this->basicMock(WeatherReportDataItem::class);
        $this->report
            = $this->basicMock(ReportInterface::class);
        $this->timezone
            = $this->basicMock(TimezoneInterface::class);
        $this->dateTime
            = $this->basicMock(DateTime::class);
        $this->converter = $this->objectManager->getObject(
            ReportEntityToReportDataItemConverter::class,
            [
                'dataItemFactory' => $this->dataItemFactory,
                'timezone'        => $this->timezone
            ]
        );
        parent::setUp();
    }

    public function testConvertWhenWeatherReportsTableIsEmpty(): void
    {
        $this->dataItemFactory->expects($this->once())
            ->method('create')->willReturn($this->dataItem);
        $this->dataItem->expects($this->never())->method('setCity');
        $this->assertEquals(
            $this->dataItem,
            $this->converter->convert($this->report)
        );
    }

    public function testConvertWhenWeatherReportSuccessfullyFetchedFromDb(): void
    {
        $this->dataItemFactory->expects($this->once())
            ->method('create')->willReturn($this->dataItem);
        $this->report->expects($this->once())->method('getId')
            ->willReturn(1);
        $this->report->expects($this->once())->method('getCity')
            ->willReturn('Lublin');
        $this->report->expects($this->once())->method('getCreatedAt')
            ->willReturn('2020-07-11 13:40:08');
        $this->timezone->expects($this->once())->method('date')
            ->willReturn($this->dateTime);
        $this->dateTime->expects($this->once())->method('format')
            ->willReturn('09/01/2017 1:40 PM');
        $this->dataItem->expects($this->once())->method('setCity');
        $this->dataItem->expects($this->once())->method('setTemperature');
        $this->dataItem->expects($this->once())->method('setHumidity');
        $this->dataItem->expects($this->once())->method('setPressure');

        $this->assertEquals(
            $this->dataItem,
            $this->converter->convert($this->report)
        );
    }
}
