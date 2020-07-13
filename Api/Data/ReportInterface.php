<?php

namespace Vs\Weather\Api\Data;

/**
 * Interface ReportInterface
 * @package Vs\Weather\Api\Data
 */
interface ReportInterface
{
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $value
     * @return void
     */
    public function setId($value);

    /**
     * @return string|null
     */
    public function getTemperature();

    /**
     * @param string $value
     * @return void
     */
    public function setTemperature(string $value);

    /**
     * @return string|null
     */
    public function getPressure();

    /**
     * @param string $value
     * @return void
     */
    public function setPressure(string $value);

    /**
     * @return string|null
     */
    public function getHumidity();

    /**
     * @param string $value
     * @return void
     */
    public function setHumidity(string $value);

    /**
     * @return string|null
     */
    public function getCity();

    /**
     * @param string $value
     * @return void
     */
    public function setCity(string $value);

    /**
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * @param string $value
     * @return void
     */
    public function setCreatedAt(string $value);
}
