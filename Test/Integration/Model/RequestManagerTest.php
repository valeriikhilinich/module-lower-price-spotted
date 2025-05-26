<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Test\Integration\Model;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;
use ValeriiKhilinich\LowerPriceSpotted\Api\Data\RequestedLowerPriceInterface;
use ValeriiKhilinich\LowerPriceSpotted\Model\RequestManager;
use ValeriiKhilinich\LowerPriceSpotted\Model\RequestStatus;
use ValeriiKhilinich\LowerPriceSpotted\Model\ResourceModel\RequestedLowerPrice as RequestedLowerPriceResource;
use ValeriiKhilinich\LowerPriceSpotted\Model\ResourceModel\RequestedLowerPrice\Collection;

class RequestManagerTest extends TestCase
{
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * @var RequestManager
     */
    private RequestManager $requestManager;

    /**
     * @var RequestedLowerPriceResource
     */
    private RequestedLowerPriceResource $requestedLowerPriceResource;

    /**
     * @var ObjectManagerInterface
     */
    private ObjectManagerInterface $objectManager;

    /**
     * @var Collection
     */
    private Collection $collection;

    /**
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     */
    public function testSaveRequestFromData()
    {
        $product = $this->productRepository->get('simple');

        $requestData = [
            'price' => '100,00',
            'email' => 'customer@example.com',
            'url' => 'https://example.com',
            'description' => null,
            'comment' => 'Test comment',
            'product_id' => $product->getId()
        ];

        $requestedLowerPrice = $this->requestManager->saveRequestFromData($requestData);

        $this->assertNotNull($requestedLowerPrice->getId());
    }

    /**
     * @magentoDataFixture ValeriiKhilinich_LowerPriceSpotted::Test/Integration/_files/requested_lower_price.php
     */
    public function testDeleteRequest()
    {
        $requestedLowerPrice = $this->loadRequest();

        $this->requestManager->deleteRequest($requestedLowerPrice);

        $requestedLowerPriceAfter = $this->loadRequest();

        $this->assertNull($requestedLowerPriceAfter->getId());
    }

    /**
     * @magentoDataFixture ValeriiKhilinich_LowerPriceSpotted::Test/Integration/_files/requested_lower_price.php
     */
    public function testApproveRequest()
    {
        $requestedLowerPrice = $this->loadRequest();

        $this->requestManager->approveRequest($requestedLowerPrice);

        $requestedLowerPriceAfter = $this->loadRequest(RequestStatus::APPROVED);

        $this->assertEquals(RequestStatus::APPROVED, $requestedLowerPriceAfter->getStatus());
    }

    /**
     * @magentoDataFixture ValeriiKhilinich_LowerPriceSpotted::Test/Integration/_files/requested_lower_price.php
     */
    public function testRejectRequest()
    {
        $requestedLowerPrice = $this->loadRequest();

        $this->requestManager->rejectRequest($requestedLowerPrice);

        $requestedLowerPriceAfter = $this->loadRequest(RequestStatus::REJECTED);

        $this->assertEquals(RequestStatus::REJECTED, $requestedLowerPriceAfter->getStatus());
    }

    /**
     * Load request data from fixture created.
     *
     * @param RequestStatus $status
     * @return RequestedLowerPriceInterface
     */
    private function loadRequest(RequestStatus $status = RequestStatus::REQUESTED): RequestedLowerPriceInterface
    {
        $requestedLowerPrice = $this->objectManager->create(RequestedLowerPriceInterface::class);

        $this->requestedLowerPriceResource->load(
            $requestedLowerPrice,
            $status->value,
            RequestedLowerPriceInterface::STATUS
        );

        return $requestedLowerPrice;
    }

    protected function setUp(): void
    {
        $this->objectManager = Bootstrap::getObjectManager();
        $this->requestManager = $this->objectManager->get(RequestManager::class);
        $this->productRepository = $this->objectManager->get(ProductRepositoryInterface::class);
        $this->requestedLowerPriceResource = $this->objectManager->get(RequestedLowerPriceResource::class);
        $this->collection = $this->objectManager->create(Collection::class);
    }
}
