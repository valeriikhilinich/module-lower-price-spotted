<?php

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\TestFramework\Helper\Bootstrap;
use ValeriiKhilinich\LowerPriceSpotted\Model\RequestedLowerPrice;
use Magento\TestFramework\Workaround\Override\Fixture\Resolver;
use ValeriiKhilinich\LowerPriceSpotted\Model\RequestStatus;
use ValeriiKhilinich\LowerPriceSpotted\Model\ResourceModel\RequestedLowerPrice as RequestedLowerPriceResource;
use ValeriiKhilinich\LowerPriceSpotted\Test\Integration\Model\PriceModificatorTest;

Resolver::getInstance()->requireDataFixture('Magento/Catalog/_files/product_simple.php');

$objectManager = Bootstrap::getObjectManager();

$productRepository = $objectManager->create(ProductRepositoryInterface::class);
$simpleProduct = $productRepository->get('simple');

$requestedLowerPrice = $objectManager->create(RequestedLowerPrice::class);
$requestedLowerPriceResource = $objectManager->get(RequestedLowerPriceResource::class);

$requestedLowerPrice->setProductId($simpleProduct->getId())
    ->setStatus(RequestStatus::REQUESTED)
    ->setEmail('customer@example.com')
    ->setPrice(PriceModificatorTest::PRICE)
    ->setReferenceUrl('https://www.example.com');

$requestedLowerPriceResource->save($requestedLowerPrice);
