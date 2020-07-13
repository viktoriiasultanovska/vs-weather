<?php

namespace Vs\Weather\Util;

/**
 * Interface WeatherReportDataItemInterface
 * @package Vs\Weather\Util
 */
class WeatherReportDataItem implements WeatherReportDataItemInterface
{
    /** @var string */
    protected $city;

    /** @var string */
    protected $temperature;

    /** @var string */
    protected $pressure;

    /** @var string */
    protected $humidity;

    /** @var string */
    protected $obtainedAt;


    public function getTemperature(): string
    {
        return $this->temperature;
    }

    public function setTemperature($value): void
    {
        $this->temperature = $value;
    }

    public function getPressure(): string
    {
        return $this->pressure;
    }

    public function setPressure(string $value): void
    {
        $this->pressure = $value;
    }

    public function getHumidity(): string
    {
        return $this->humidity;
    }

    public function setHumidity(string $value): void
    {
        $this->humidity = $value;
    }
    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $value): void
    {
        $this->city = $value;
    }

    public function getObtainedAt()
    {
        return $this->obtainedAt;
    }

    public function setObtainedAt($obtainedAt): void
    {
        $this->obtainedAt = $obtainedAt;
    }
}
