<?php

namespace Vs\Weather\Controller\Adminhtml\System\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json as JsonResult;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Filter\StripTags;
use Vs\Weather\ApiClient\ClientInterface;
use Vs\Weather\Model\Api\ApiUrlBuilder;

/**
 * Class TestOpenWeatherMapConnection
 * @package Vs\Weather\Controller\Adminhtml\System\Config
 */
class TestConnection extends Action
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Vs_Weather::weather_report';

    /** @var JsonFactory */
    private $resultJsonFactory;

    /** @var StripTags */
    private $tagFilter;

    /** @var ClientInterface */
    private $apiClient;

    /** @var ApiUrlBuilder */
    private $urlBuilder;

    /**
     * TestOpenWeatherMapConnection constructor.
     *
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param StripTags $tagFilter
     * @param ClientInterface $apiClient
     * @param ApiUrlBuilder $urlBuilder
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        StripTags $tagFilter,
        ClientInterface $apiClient,
        ApiUrlBuilder $urlBuilder
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->tagFilter = $tagFilter;
        $this->apiClient = $apiClient;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Check for connection to server
     *
     * @return JsonResult
     */
    public function execute(): JsonResult
    {
        try {
            $this->apiClient->call(
                $this->urlBuilder->getApiUrl($this->getWebsiteIdFromRequest())
            );
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $msg = $this->tagFilter->filter($e->getMessage());
        }
        $resultJson = $this->resultJsonFactory->create();

        return $resultJson->setData([
            'success'      => $success,
            'errorMessage' => $msg ?? '',
        ]);
    }

    /**
     * @return int
     */
    protected function getWebsiteIdFromRequest(): int
    {
        return (int)$this->getRequest()
            ->getParam('website_id', null);
    }
}
