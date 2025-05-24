<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Model;

use DateTime;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use ValeriiKhilinich\LowerPriceSpotted\Api\Data\RequestedLowerPriceInterface;
use ValeriiKhilinich\LowerPriceSpotted\Model\ResourceModel\RequestedLowerPrice as RequestedLowerPriceResource;

class RequestedLowerPrice extends AbstractModel implements RequestedLowerPriceInterface
{
    /**
     * @inheritDoc
     *
     * @throws LocalizedException
     */
    protected function _construct(): void
    {
        $this->_init(RequestedLowerPriceResource::class);
    }

    /**
     * @inheritDoc
     */
    public function getProductId(): int
    {
        return (int)$this->getData(self::PRODUCT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setProductId(int $productId): RequestedLowerPriceInterface
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): RequestStatus
    {
        return RequestStatus::from((int)$this->getData(self::STATUS));
    }

    /**
     * @inheritDoc
     */
    public function setStatus(RequestStatus $status): RequestedLowerPriceInterface
    {
        return $this->setData(self::STATUS, $status->value);
    }

    /**
     * @inheritDoc
     */
    public function getReferenceUrl(): ?string
    {
        return $this->getData(self::REFERENCE_URL);
    }

    /**
     * @inheritDoc
     */
    public function setReferenceUrl(?string $referenceUrl): RequestedLowerPriceInterface
    {
        return $this->setData(self::REFERENCE_URL, $referenceUrl);
    }

    /**
     * @inheritDoc
     */
    public function getCompetitorDescription(): ?string
    {
        return $this->getData(self::COMPETITOR_DESCRIPTION);
    }

    /**
     * @inheritDoc
     */
    public function setCompetitorDescription(?string $competitorDescription): RequestedLowerPriceInterface
    {
        return $this->setData(self::COMPETITOR_DESCRIPTION, $competitorDescription);
    }

    /**
     * @inheritDoc
     */
    public function getEmail(): string
    {
        return (string)$this->getData(self::EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setEmail(string $email): RequestedLowerPriceInterface
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * @inheritDoc
     */
    public function getPrice(): float
    {
        return (float)$this->getData(self::PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setPrice(float $price): RequestedLowerPriceInterface
    {
        return $this->setData(self::PRICE, $price);
    }

    /**
     * @inheritDoc
     */
    public function getComment(): ?string
    {
        return $this->getData(self::COMMENT);
    }

    /**
     * @inheritDoc
     */
    public function setComment(?string $comment): RequestedLowerPriceInterface
    {
        return $this->setData(self::COMMENT, $comment);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->getData(self::CREATED_AT));
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(DateTime $createdAt): RequestedLowerPriceInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
