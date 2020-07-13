<?php

namespace Vs\Weather\Controller\Adminhtml\Report;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Vs\Weather\Api\ReportRepositoryInterface;
use Vs\Weather\Model\Report;

/**
 * Class InlineEdit
 * @package Vs\Weather\Controller\Adminhtml\Report
 */
class InlineEdit extends Action
{
    const ADMIN_RESOURCE = 'Vs_Weather::weather_report';

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var ReportRepositoryInterface
     */
    private $repository;

    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param ReportRepositoryInterface $repository
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        ReportRepositoryInterface $repository
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->repository = $repository;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        try {
            foreach (array_keys($postItems) as $reportId) {
                /** @var  Report $report */
                $report = $this->repository->getById($reportId);
                $report->setData(array_merge($report->getData(), $postItems[$reportId]));
                $this->repository->save($report);
            }
        } catch (Exception $e) {
            $messages[] = __('There was an error saving the data: ') . $e->getMessage();
            $error = true;
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
