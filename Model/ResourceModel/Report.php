<?php

namespace Vs\Weather\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Report
 * @package Vs\Weather\Model\ResourceModel
 */
class Report extends AbstractDb
{
    const TABLE_NAME = 'vs_weather_report';
    const COLUMN_ID = 'entity_id';
    const COLUMN_TEMPERATURE = 'temperature';
    const COLUMN_PRESSURE = 'pressure';
    const COLUMN_HUMIDITY = 'humidity';
    const COLUMN_CITY = 'city';
    const COLUMN_CREATED_AT = 'created_at';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::COLUMN_ID);
    }
}
