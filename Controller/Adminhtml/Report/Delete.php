<?php

namespace Vs\Weather\Controller\Adminhtml\Report;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Vs\Weather\Model\ReportFactory;

/**
 * Class Delete
 * @package Vs\Weather\Controller\Adminhtml\Report
 */
class Delete extends Action
{
    const ADMIN_RESOURCE = 'Vs_Weather::weather_report';

    /**
     * @var reportFactory $objectFactory
     */
    protected $objectFactory;

    /**
     * @param Context $context
     * @param ReportFactory $objectFactory
     */
    public function __construct(
        Context $context,
        ReportFactory $objectFactory
    ) {
        $this->objectFactory = $objectFactory;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id', null);

        try {
            $objectInstance = $this->objectFactory->create()->load($id);
            if ($objectInstance->getId()) {
                $objectInstance->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the record.'));
            } else {
                $this->messageManager->addErrorMessage(__('Record does not exist.'));
            }
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect->setPath('*/*');
    }
}
