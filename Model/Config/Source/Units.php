<?php

namespace Vs\Weather\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Units
 * @package Vs\Weather\Model\Config\Source
 */
class Units implements OptionSourceInterface
{
    public const WEATHER_API_UNIT_METRIC = 'metric';
    public const WEATHER_API_UNIT_IMPERIAL = 'imperial';

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            self::WEATHER_API_UNIT_METRIC   => __('Metric'),
            self::WEATHER_API_UNIT_IMPERIAL => __('Imperial')
        ];
    }
}
