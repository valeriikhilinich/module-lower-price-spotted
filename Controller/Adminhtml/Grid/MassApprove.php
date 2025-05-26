<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use ValeriiKhilinich\LowerPriceSpotted\Api\Data\RequestedLowerPriceInterface;
use ValeriiKhilinich\LowerPriceSpotted\Model\RequestManager;
use ValeriiKhilinich\LowerPriceSpotted\Model\RequestStatus;
use ValeriiKhilinich\LowerPriceSpotted\Model\ResourceModel\RequestedLowerPrice\CollectionFactory;

class MassApprove extends Action implements HttpPostActionInterface
{
    /**
     * @inheritDoc
     */
    public const ADMIN_RESOURCE = 'ValeriiKhilinich_LowerPriceSpotted::delete_requests';

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param RequestManager $requestManager
     */
    public function __construct(
        Context $context,
        private readonly Filter $filter,
        private readonly CollectionFactory $collectionFactory,
        private readonly RequestManager $requestManager,
    ) {
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     *
     * @throws LocalizedException
     */
    public function execute(): Redirect
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        /** @var RequestedLowerPriceInterface $requestedLowerPrice */
        foreach ($collection as $requestedLowerPrice) {
            $this->requestManager->approveRequest($requestedLowerPrice->setStatus(RequestStatus::APPROVED));
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have approved.', $collectionSize));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
