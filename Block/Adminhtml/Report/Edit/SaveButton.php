<?php

namespace Vs\Weather\Block\Adminhtml\Report\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 * @package Vs\Weather\Block\Adminhtml\Report\Edit
 */
class SaveButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
        return $data;
    }
}
