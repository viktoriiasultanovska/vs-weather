<?php

namespace Vs\Weather\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface ReportSearchResultInterface
 * @package Vs\Weather\Api\Data
 */
interface ReportSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Vs\Weather\Api\Data\ReportInterface[]
     */
    public function getItems();

    /**
     * @param \Vs\Weather\Api\Data\ReportInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
