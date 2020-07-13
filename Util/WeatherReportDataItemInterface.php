<?php

namespace Vs\Weather\Util;

/**
 * Interface WeatherReportDataItemInterface
 * @package Vs\Weather\Util
 */
interface WeatherReportDataItemInterface
{
    /**
     * @return string
     */
    public function getTemperature(): string;

    /**
     * @param $value
     *
     * @return string
     */
    public function setTemperature($value): void;

    /**
     * @return string
     */
    public function getPressure(): string;

    /**
     * @param string $value
     */
    public function setPressure(string $value): void;

    /**
     * @return string
     */
    public function getHumidity(): string;

    /**
     * @param string $value
     */
    public function setHumidity(string $value): void;

    /**
     * @return string
     */
    public function getCity(): string;

    /**
     * @param string $value
     */
    public function setCity(string $value): void;

    /**
     * @return mixed
     */
    public function getObtainedAt();

    /**
     * @param $value
     *
     * @return string
     */
    public function setObtainedAt($value);

}
