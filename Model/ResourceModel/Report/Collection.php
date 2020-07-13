<?php

namespace Vs\Weather\Model\ResourceModel\Report;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Vs\Weather\Model\Report;
use Vs\Weather\Model\ResourceModel\Report as ReportResourceModel;

/**
 * Class Collection
 * @package Vs\Weather\Model\ResourceModel\Report
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Report::class, ReportResourceModel::class);
    }
}
