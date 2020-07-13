<?php

namespace Vs\Weather\Model;

use Magento\Framework\Model\AbstractModel;
use Vs\Weather\Api\Data\ReportInterface;
use Vs\Weather\Model\ResourceModel\Report as ReportResourceModel;

/**
 * Class Report
 * @package Vs\Weather\Model
 */
class Report extends AbstractModel implements ReportInterface
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ReportResourceModel::class);
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->_getData('entity_id');
    }

    /**
     * @param int $value
     *
     * @return void
     */
    public function setId($value)
    {
        $this->setData('entity_id', $value);
    }

    /**
     * @return string|null
     */
    public function getTemperature()
    {
        return $this->getData(ReportResourceModel::COLUMN_TEMPERATURE);
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setTemperature(string $value)
    {
        $this->setData(ReportResourceModel::COLUMN_TEMPERATURE, $value);
    }

    /**
     * @return string|null
     */
    public function getPressure()
    {
        return $this->getData(ReportResourceModel::COLUMN_PRESSURE);
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setPressure(string $value)
    {
        $this->setData(ReportResourceModel::COLUMN_PRESSURE, $value);
    }

    /**
     * @return string|null
     */
    public function getHumidity()
    {
        return $this->getData(ReportResourceModel::COLUMN_HUMIDITY);
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setHumidity(string $value)
    {
        $this->setData(ReportResourceModel::COLUMN_HUMIDITY, $value);
    }

    /**
     * @return string|null
     */
    public function getCity()
    {
        return $this->getData(ReportResourceModel::COLUMN_CITY);
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setCity(string $value)
    {
        $this->setData(ReportResourceModel::COLUMN_CITY, $value);
    }

    /**
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(ReportResourceModel::COLUMN_CREATED_AT);
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function setCreatedAt(string $value)
    {
        $this->setData(ReportResourceModel::COLUMN_CREATED_AT, $value);
    }
}
