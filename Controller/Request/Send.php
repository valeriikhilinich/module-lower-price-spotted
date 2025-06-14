<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Controller\Request;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;
use ValeriiKhilinich\LowerPriceSpotted\Exception\InvalidRequestDataException;
use ValeriiKhilinich\LowerPriceSpotted\Model\Config\ConfigProvider;
use ValeriiKhilinich\LowerPriceSpotted\Model\RequestDataProcessor;
use ValeriiKhilinich\LowerPriceSpotted\Model\RequestManager;

class Send implements HttpPostActionInterface
{
    /**
     * @param RequestInterface $request
     * @param ResultFactory $resultFactory
     * @param ManagerInterface $messageManager
     * @param RequestDataProcessor $requestDataProcessor
     * @param RequestManager $requestManager
     * @param LoggerInterface $logger
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        private readonly RequestInterface $request,
        private readonly ResultFactory $resultFactory,
        private readonly ManagerInterface $messageManager,
        private readonly RequestDataProcessor $requestDataProcessor,
        private readonly RequestManager $requestManager,
        private readonly LoggerInterface $logger,
        private readonly ConfigProvider $configProvider,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(): ResultInterface
    {
        if (!$this->configProvider->isEnabled()) {
            return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)
                ->forward('noroute');
        }

        $productId = $this->request->getParam("product_id");
        $data = $this->request->getPostValue();

        if (!$productId) {
            $this->messageManager->addErrorMessage(__('Pass product id to send price lower request!'));

            return $this->prepareResponseResult(false);
        }

        try {
            $preparedData = $this->requestDataProcessor->processData($data);
            $preparedData['product_id'] = $productId;

            $this->requestManager->saveRequestFromData($preparedData);
        } catch (InvalidRequestDataException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());

            return $this->prepareResponseResult(false);
        } catch (AlreadyExistsException $exception) {
            $this->logger->error($exception->getMessage());
            $this->messageManager->addErrorMessage(__('Something went wrong while sending request!'));

            return $this->prepareResponseResult(false);
        }

        $this->messageManager->addSuccessMessage(__('You have been successfully sent request!'));

        return $this->prepareResponseResult(true);
    }

    /**
     * Prepare a response to an ajax request.
     *
     * @param bool $success
     * @return ResultInterface
     */
    private function prepareResponseResult(bool $success): ResultInterface
    {
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)
            ->setData([
                'success' => $success,
            ]);
    }
}
