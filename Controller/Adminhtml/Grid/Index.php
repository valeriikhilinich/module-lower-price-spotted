<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Controller\Adminhtml\Grid;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use ValeriiKhilinich\LowerPriceSpotted\Model\Config\ConfigProvider;

class Index extends Action
{
    /**
     * @inheritDoc
     */
    public const ADMIN_RESOURCE = 'ValeriiKhilinich_LowerPriceSpotted::view_requests';

    /**
     * @param Context $context
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        Context $context,
        private readonly ConfigProvider $configProvider,
    ) {
        parent::__construct($context);
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

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('ValeriiKhilinich_LowerPriceSpotted::view_requests');
        $resultPage->addBreadcrumb(__('Lower Price Requests'), __('Lower Price Requests'));
        $resultPage->getConfig()->getTitle()->prepend(__('Lower Price Requests'));

        return $resultPage;
    }
}
