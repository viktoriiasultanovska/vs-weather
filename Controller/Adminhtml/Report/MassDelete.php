<?php

namespace Vs\Weather\Controller\Adminhtml\Report;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Vs\Weather\Model\ResourceModel\Report\Collection;

/**
 * Class MassDelete
 * @package Vs\Weather\Controller\Adminhtml\Report
 */
class MassDelete extends Action
{
    const ADMIN_RESOURCE = 'Vs_Weather::weather_report';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var Collection $objectCollection
     */
    protected $objectCollection;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param Collection $objectCollection
     */
    public function __construct(Context $context, Filter $filter, Collection $objectCollection)
    {
        $this->filter = $filter;
        $this->objectCollection = $objectCollection;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->objectCollection);
        $collectionSize = $collection->getSize();
        $collection->walk('delete');

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
