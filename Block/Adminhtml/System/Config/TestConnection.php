<?php

namespace Vs\Weather\Block\Adminhtml\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class OpenWeatherMap
 * @package Vs\Weather\Block\Adminhtml\System\Config\Check
 */
class TestConnection extends Check
{
    protected $url = 'vs_weather/system_config/testconnection';

    /**
     * Get the button and scripts contents
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $originalData = $element->getOriginalData();
        $this->addData(
            [
                'button_label' => __($originalData['button_label']),
                'html_id' => $element->getHtmlId(),
                'ajax_url' => $this->_urlBuilder->getUrl($this->url),
                'field_mapping' => str_replace('"', '\\"', json_encode($this->_getFieldMapping()))
            ]
        );

        return $this->_toHtml();
    }

    /**
     * {@inheritdoc}
     */
    protected function _getFieldMapping()
    {
        $fields = [
            'website_id' => 'website_switcher'
        ];
        return array_merge(parent::_getFieldMapping(), $fields);
    }
}
