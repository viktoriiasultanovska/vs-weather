<?php
namespace Vs\Weather\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;

/**
 * Class Check
 * @package Vs\Weather\Block\Adminhtml\System\Config
 */
abstract class Check extends Field
{
    /**
     * Url to check action
     * @var string
     */

    protected $url = '';

    /**
     * Set template to itself
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->setTemplate('Vs_Weather::system/config/check.phtml');
        return $this;
    }


    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element = clone $element;
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Get the button and scripts contents
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $originalData = $element->getOriginalData();
        $this->addData(
            [
                'button_label' => __($originalData['button_label']),
                'html_id' => $element->getHtmlId(),
                'ajax_url' => $this->_urlBuilder->getUrl($this->url),
                'field_mapping' => $this->escapeJsQuote(json_encode($this->_getFieldMapping()), '"')
            ]
        );

        return $this->_toHtml();
    }

    /**
     * Returns configuration fields required to perform the ping request
     *
     * @return array
     */
    protected function _getFieldMapping()
    {
        return [];
    }
}
