<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Test\Integration\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Fixture\DataFixture;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;
use ValeriiKhilinich\LowerPriceSpotted\Api\Data\RequestedLowerPriceInterface;
use ValeriiKhilinich\LowerPriceSpotted\Model\PriceModificator;
use ValeriiKhilinich\LowerPriceSpotted\Model\RequestStatus;
use ValeriiKhilinich\LowerPriceSpotted\Model\ResourceModel\RequestedLowerPrice as RequestedLowerPriceResource;

class PriceModificatorTest extends TestCase
{
    public const PRICE = 100;

    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * @var PriceModificator
     */
    private PriceModificator $priceModifier;
    /**
     * @var RequestedLowerPriceResource
     */
    private RequestedLowerPriceResource $requestedLowerPriceResource;

    /**
     * @var ObjectManagerInterface
     */
    private ObjectManagerInterface $objectManager;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->priceModifier = $this->objectManager->get(PriceModificator::class);
        $this->productRepository = $this->objectManager->get(ProductRepositoryInterface::class);
        $this->requestedLowerPriceResource = $this->objectManager->get(RequestedLowerPriceResource::class);
    }

    /**
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     * @magentoDataFixture ValeriiKhilinich_LowerPriceSpotted::Test/Integration/_files/approved_requested_lower_price.php
     */
    public function testModify()
    {
        $requestedLowerPrice = $this->objectManager->create(RequestedLowerPriceInterface::class);

        $this->requestedLowerPriceResource->load(
            $requestedLowerPrice,
            RequestStatus::APPROVED->value,
            RequestedLowerPriceInterface::STATUS
        );

        $this->priceModifier->modify($requestedLowerPrice);

        $changedProduct = $this->productRepository->get('simple');
        $this->assertEquals($changedProduct->getPrice(), self::PRICE);
    }
}
