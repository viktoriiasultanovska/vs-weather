<?php

namespace Vs\Weather\Model;

use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Vs\Weather\Api\Data\ReportInterface;
use Vs\Weather\Api\Data\ReportSearchResultInterface;
use Vs\Weather\Api\Data\ReportSearchResultInterfaceFactory;
use Vs\Weather\Api\ReportRepositoryInterface;
use Vs\Weather\Model\ResourceModel\Report\Collection;
use Vs\Weather\Model\ResourceModel\Report\CollectionFactory as ReportCollectionFactory;

/**
 * Class ReportRepository
 * @package Vs\Weather\Model
 */
class ReportRepository implements ReportRepositoryInterface
{
    /** @var ReportFactory */
    private $reportFactory;

    /** @var ReportCollectionFactory */
    private $reportCollectionFactory;

    /** @var ReportSearchResultInterfaceFactory */
    private $searchResultFactory;

    /**
     * ReportRepository constructor.
     *
     * @param ReportFactory $reportFactory
     * @param ReportCollectionFactory $reportCollectionFactory
     * @param ReportSearchResultInterfaceFactory $reportSearchResultInterfaceFactory
     */
    public function __construct(
        ReportFactory $reportFactory,
        ReportCollectionFactory $reportCollectionFactory,
        ReportSearchResultInterfaceFactory $reportSearchResultInterfaceFactory
    ) {
        $this->reportFactory = $reportFactory;
        $this->reportCollectionFactory = $reportCollectionFactory;
        $this->searchResultFactory = $reportSearchResultInterfaceFactory;
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        $report = $this->reportFactory->create();
        $report->getResource()->load($report, $id);
        if (!$report->getId()) {
            throw new NoSuchEntityException(__('Unable to find Report with ID "%1"', $id));
        }
        return $report;
    }

    /**
     * @inheritDoc
     * @throws AlreadyExistsException
     */
    public function save(ReportInterface $report)
    {
        /** @var $report Report **/
        $report->getResource()->save($report);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function delete(ReportInterface $report)
    {
        /** @var $report Report **/
        $report->getResource()->delete($report);
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->reportCollectionFactory->create();
        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);
        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addFiltersToCollection(
        SearchCriteriaInterface $searchCriteria,
        Collection $collection
    ): void {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[]
                    = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addSortOrdersToCollection(
        SearchCriteriaInterface $searchCriteria,
        Collection $collection
    ): void {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC
                ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addPagingToCollection(
        SearchCriteriaInterface $searchCriteria,
        Collection $collection
    ): void {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     *
     * @return ReportSearchResultInterface
     */
    private function buildSearchResult(
        SearchCriteriaInterface $searchCriteria,
        Collection $collection
    ): ReportSearchResultInterface {
        /** @var ReportSearchResultInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
