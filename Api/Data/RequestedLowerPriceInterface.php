<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Api\Data;

use DateMalformedStringException;
use DateTime;
use ValeriiKhilinich\LowerPriceSpotted\Model\RequestStatus;

interface RequestedLowerPriceInterface
{
    public const REQUEST_ID = "request_id";
    public const PRODUCT_ID = "product_id";
    public const STATUS = "status";
    public const REFERENCE_URL = "reference_url";
    public const COMPETITOR_DESCRIPTION = "competitor_description";
    public const EMAIL = "email";
    public const PRICE = "price";
    public const COMMENT = "comment";
    public const CREATED_AT = 'created_at';

    /**
     * @return int
     */
    public function getProductId(): int;

    /**
     * @param int $productId
     * @return RequestedLowerPriceInterface
     */
    public function setProductId(int $productId): RequestedLowerPriceInterface;

    /**
     * @return RequestStatus
     */
    public function getStatus(): RequestStatus;

    /**
     * @param RequestStatus $status
     * @return RequestedLowerPriceInterface
     */
    public function setStatus(RequestStatus $status): RequestedLowerPriceInterface;

    /**
     * @return string|null
     */
    public function getReferenceUrl(): ?string;

    /**
     * @param string|null $referenceUrl
     * @return RequestedLowerPriceInterface
     */
    public function setReferenceUrl(?string $referenceUrl): RequestedLowerPriceInterface;

    /**
     * @return string|null
     */
    public function getCompetitorDescription(): ?string;

    /**
     * @param string|null $competitorDescription
     * @return RequestedLowerPriceInterface
     */
    public function setCompetitorDescription(?string $competitorDescription): RequestedLowerPriceInterface;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     * @return RequestedLowerPriceInterface
     */
    public function setEmail(string $email): RequestedLowerPriceInterface;

    /**
     * @return float
     */
    public function getPrice(): float;

    /**
     * @param float $price
     * @return RequestedLowerPriceInterface
     */
    public function setPrice(float $price): RequestedLowerPriceInterface;

    /**
     * @return string|null
     */
    public function getComment(): ?string;

    /**
     * @param string|null $comment
     * @return RequestedLowerPriceInterface
     */
    public function setComment(?string $comment): RequestedLowerPriceInterface;

    /**
     * @return DateTime
     *
     * @throws DateMalformedStringException
     */
    public function getCreatedAt(): DateTime;

    /**
     * @param DateTime $createdAt
     * @return RequestedLowerPriceInterface
     */
    public function setCreatedAt(DateTime $createdAt): RequestedLowerPriceInterface;
}
