<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use ValeriiKhilinich\LowerPriceSpotted\Api\Data\RequestedLowerPriceInterface;

class PriceModificator
{
    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(private readonly ProductRepositoryInterface $productRepository)
    {
    }

    /**
     * Change the price of the product in accordance with the price lower request.
     *
     * @param RequestedLowerPriceInterface $requestedLowerPrice
     *
     * @throws CouldNotSaveException
     * @throws InputException
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function modify(RequestedLowerPriceInterface $requestedLowerPrice): void
    {
        $product = $this->productRepository->getById($requestedLowerPrice->getProductId());

        $product->setPrice($requestedLowerPrice->getPrice());

        $this->productRepository->save($product);
    }
}
