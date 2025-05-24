<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Model;

use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use ValeriiKhilinich\LowerPriceSpotted\Api\Data\RequestedLowerPriceInterface;
use ValeriiKhilinich\LowerPriceSpotted\Model\ResourceModel\RequestedLowerPrice as RequestedLowerPriceResource;

class RequestManager
{
    /**
     * @param RequestedLowerPriceResource $requestedLowerPriceResource
     * @param PriceModificator $priceModificator
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly RequestedLowerPriceResource $requestedLowerPriceResource,
        private readonly PriceModificator $priceModificator,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Perform the delete request action.
     *
     * @param RequestedLowerPriceInterface $requestedLowerPrice
     *
     * @throws Exception
     */
    public function deleteRequest(RequestedLowerPriceInterface $requestedLowerPrice): void
    {
        $this->requestedLowerPriceResource->delete($requestedLowerPrice);
    }

    /**
     * Perform the reject request action.
     *
     * @param RequestedLowerPriceInterface $requestedLowerPrice
     *
     * @return RequestedLowerPriceInterface
     *
     * @throws AlreadyExistsException
     */
    public function rejectRequest(RequestedLowerPriceInterface $requestedLowerPrice): RequestedLowerPriceInterface
    {
        $this->requestedLowerPriceResource->save($requestedLowerPrice->setStatus(RequestStatus::REJECTED));

        return $requestedLowerPrice;
    }

    /**
     * Perform the delete request action.
     *
     * @param RequestedLowerPriceInterface $requestedLowerPrice
     *
     * @return RequestedLowerPriceInterface
     *
     * @throws LocalizedException
     */
    public function approveRequest(RequestedLowerPriceInterface $requestedLowerPrice): RequestedLowerPriceInterface
    {
        $requestedLowerPrice->setStatus(RequestStatus::APPROVED);

        $connection = $this->requestedLowerPriceResource->getConnection();
        $connection->beginTransaction();

        try {
            $this->priceModificator->modify($requestedLowerPrice);

            $this->requestedLowerPriceResource->save($requestedLowerPrice);
            $connection->commit();
        } catch (\Exception $exception) {
            $connection->rollBack();

            $this->logger->error($exception->getMessage());
            throw new LocalizedException(__('Something went wrong while modifying the requested price.'));
        }

        return $requestedLowerPrice;
    }
}
