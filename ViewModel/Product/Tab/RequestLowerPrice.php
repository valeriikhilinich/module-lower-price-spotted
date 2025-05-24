<?php

namespace ValeriiKhilinich\LowerPriceSpotted\ViewModel\Product\Tab;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class RequestLowerPrice implements ArgumentInterface
{
    /**
     * @param UrlInterface $urlBuilder
     * @param RequestInterface $request
     */
    public function __construct(
        private readonly UrlInterface $urlBuilder,
        private readonly RequestInterface $request
    ) {
    }

    /**
     * Build form submit url.
     *
     * @return string
     */
    public function getSubmitUrl(): string
    {
        return $this->urlBuilder->getUrl(
            'lowerprice/request/send',
            ['product_id' => $this->request->getParam('id')]
        );
    }
}
