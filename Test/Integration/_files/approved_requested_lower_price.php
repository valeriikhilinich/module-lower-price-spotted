<?php

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\Workaround\Override\Fixture\Resolver;
use ValeriiKhilinich\LowerPriceSpotted\Api\Data\RequestedLowerPriceInterface;
use ValeriiKhilinich\LowerPriceSpotted\Model\RequestStatus;
use ValeriiKhilinich\LowerPriceSpotted\Model\ResourceModel\RequestedLowerPrice\Collection as RequestedLowerPriceCollection;
use ValeriiKhilinich\LowerPriceSpotted\Model\ResourceModel\RequestedLowerPrice as RequestedLowerPriceResource;

Resolver::getInstance()->requireDataFixture('ValeriiKhilinich_LowerPriceSpotted::Test/Integration/_files/requested_lower_price.php');

$objectManager = Bootstrap::getObjectManager();

$collection = $objectManager->create(RequestedLowerPriceCollection::class);
$requestedLowerPriceResource = $objectManager->get(RequestedLowerPriceResource::class);

$collection->addFieldToFilter(RequestedLowerPriceInterface::STATUS, RequestStatus::REQUESTED->value);

/** @var RequestedLowerPriceInterface $requestedLowerPriceToApprove */
$requestedLowerPriceToApprove = $collection->getFirstItem()
    ->setStatus(RequestStatus::APPROVED);

$requestedLowerPriceResource->save($requestedLowerPriceToApprove);
