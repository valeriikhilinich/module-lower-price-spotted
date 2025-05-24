<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Model\Validator;

use Laminas\Validator\EmailAddress;
use ValeriiKhilinich\LowerPriceSpotted\Api\ValidatorInterface;
use ValeriiKhilinich\LowerPriceSpotted\Exception\InvalidRequestDataException;

class SenderEmail implements ValidatorInterface
{
    /**
     * @param EmailAddress $emailAddress
     */
    public function __construct(protected EmailAddress $emailAddress)
    {
    }

    /**
     * @inheritDoc
     */
    public function validate(array $data): void
    {
        if (!$this->emailAddress->isValid($data['email'])) {
            throw new InvalidRequestDataException(__('Email address is invalid!'));
        }
    }
}
