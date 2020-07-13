<?php

namespace Vs\Weather\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Vs\Weather\Api\Data\ReportInterface;

/**
 * Interface ReportRepositoryInterface
 * @package Vs\Weather\Api
 */
interface ReportRepositoryInterface
{
    /**
     * @param int $id
     * @return \Vs\Weather\Api\Data\ReportInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \Vs\Weather\Api\Data\ReportInterface
     * @return void
     */
    public function save(ReportInterface $Report);

    /**
     * @param \Vs\Weather\Api\Data\ReportInterface
     * @return void
     */
    public function delete(ReportInterface $Report);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Vs\Weather\Api\Data\ReportSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
