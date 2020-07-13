<?php

namespace Vs\Weather\Test\Unit\Model;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\TestFramework\Unit\BaseTestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Vs\Weather\Api\Data\ReportInterface;
use Vs\Weather\Api\Data\ReportSearchResultInterface;
use Vs\Weather\Model\ReportRepository;
use Vs\Weather\Model\ResourceModel\Report as ReportResourceModel;
use Vs\Weather\Model\WeatherReportManagement;

/**
 * /**
 * Class WeatherReportManagementTest
 * @package Vs\Weather\Test\Unit\Model
 */
class WeatherReportManagementTest extends BaseTestCase
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var WeatherReportManagement | MockObject */
    protected $weatherReportManagement;

    /** @var SortOrderBuilder | MockObject */
    private $sortOrderBuilder;

    /** @var SearchCriteriaBuilder | MockObject */
    private $searchCriteriaBuilder;

    /** @var ReportRepository */
    private $reportRepository;

    /** @var ReportSearchResultInterface | MockObject */
    private $reportSearchResult;

    /** @var SearchCriteriaInterface | MockObject */
    private $searchCriteria;

    /** @var ReportInterface | MockObject */
    protected $report;

    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->sortOrderBuilder = $this->basicMock(SortOrderBuilder::class);
        $this->searchCriteriaBuilder
            = $this->basicMock(SearchCriteriaBuilder::class);
        $this->reportRepository = $this->basicMock(ReportRepository::class);
        $this->reportSearchResult
            = $this->basicMock(ReportSearchResultInterface::class);
        $this->searchCriteria
            = $this->basicMock(SearchCriteriaInterface::class);
        $this->report = $this->basicMock(ReportInterface::class);
        $this->weatherReportManagement = $this->objectManager->getObject(
            WeatherReportManagement::class,
            [
                'sortOrderBuilder'      => $this->sortOrderBuilder,
                'searchCriteriaBuilder' => $this->searchCriteriaBuilder,
                'reportRepository'      => $this->reportRepository
            ]
        );
        parent::setUp();
    }

    public function testGetLatestCityWeatherReportEmptyResult(): void
    {
        $city = 'London';
        $this->prepareSearchCriterias();
        $this->reportSearchResult->expects($this->once())
            ->method('getItems')->willReturn([]);
        $this->expectException(NoSuchEntityException::class);
        $this->weatherReportManagement->getLatestCityWeatherReport($city);
    }

    public function testGetLatestCityWeatherReportNotEmptyResult(): void
    {
        $city = 'London';
        $this->prepareSearchCriterias();
        $this->reportSearchResult->expects($this->once())
            ->method('getItems')->willReturn([$this->report]);

        $actualResult = $this->weatherReportManagement->getLatestCityWeatherReport($city);
        $expectedResult = $this->report;
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function testGetLatestCityWeatherReportMultipleItemsReturned(): void
    {
        $city = 'London';

        $this->prepareSearchCriterias();
        $report1 = $this->basicMock(ReportInterface::class);
        $report2 = $this->basicMock(ReportInterface::class);
        $report3 = $this->basicMock(ReportInterface::class);

        $this->reportSearchResult->expects($this->once())
            ->method('getItems')
            ->willReturn([$report1, $report2, $report3]);

        $actualResult = $this->weatherReportManagement
            ->getLatestCityWeatherReport($city);
        $this->assertInstanceOf(ReportInterface::class, $actualResult);
    }

    protected function prepareSearchCriterias()
    {
        $this->sortOrderBuilder->expects($this->once())->method('setField')
            ->with(ReportResourceModel::COLUMN_CREATED_AT)
            ->willReturnSelf();
        $this->sortOrderBuilder->expects($this->once())->method('setDirection')
            ->with(SortOrder::SORT_DESC)
            ->willReturnSelf();
        $this->sortOrderBuilder->expects($this->once())->method('create')
            ->willReturnSelf();
        $this->searchCriteriaBuilder->expects($this->once())
            ->method('setPageSize')->willReturnSelf();
        $this->searchCriteriaBuilder->expects($this->once())
            ->method('setCurrentPage')->willReturnSelf();
        $this->searchCriteriaBuilder->expects($this->once())
            ->method('addFilter')->willReturnSelf();
        $this->searchCriteriaBuilder->expects($this->once())
            ->method('addSortOrder')
            ->with($this->sortOrderBuilder)->willReturnSelf();
        $this->searchCriteriaBuilder->expects($this->once())
            ->method('create')
            ->willReturn($this->searchCriteria);
        $this->reportRepository->expects($this->once())->method('getList')
            ->with($this->searchCriteria)
            ->willReturn($this->reportSearchResult);
    }
}
