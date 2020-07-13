<?php

namespace Vs\Weather\Model;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;
use Vs\Weather\Api\Data\ReportInterface;
use Vs\Weather\Api\WeatherReportManagementInterface;
use Vs\Weather\Model\ResourceModel\Report as ReportResourceModel;

/**
 * Class WeatherReportManagement
 * @package Vs\Weather\Model
 */
class WeatherReportManagement implements WeatherReportManagementInterface
{
    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /** @var ReportRepository */
    private $reportRepository;

    /** @var SortOrderBuilder */
    private $sortOrderBuilder;

    /**
     * WeatherReportManagement constructor.
     *
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param ReportRepository $reportRepository
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        ReportRepository $reportRepository
    ) {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->reportRepository = $reportRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @inheritDoc
     */
    public function getLatestCityWeatherReport($city): ReportInterface
    {
        $sortOrder = $this->sortOrderBuilder
            ->setField(ReportResourceModel::COLUMN_CREATED_AT)
            ->setDirection(SortOrder::SORT_DESC)
            ->create();
        $searchCriteria = $this->searchCriteriaBuilder
            ->setPageSize(1)
            ->setCurrentPage(1)
            ->addFilter(ReportResourceModel::COLUMN_CITY, $city)
            ->addSortOrder($sortOrder)
            ->create();
        $items = $this->reportRepository
            ->getList($searchCriteria)->getItems();
        if (count($items) === 0) {
            throw new NoSuchEntityException(
                new Phrase('Weather Report item was not found.')
            );
        }

        return array_pop($items);
    }
}
