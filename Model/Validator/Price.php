<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Model\Validator;

use Laminas\I18n\Validator\IsFloat;
use ValeriiKhilinich\LowerPriceSpotted\Api\ValidatorInterface;
use ValeriiKhilinich\LowerPriceSpotted\Exception\InvalidRequestDataException;

class Price implements ValidatorInterface
{
    /**
     * @param IsFloat $isFloat
     */
    public function __construct(private readonly IsFloat $isFloat)
    {
    }

    /**
     * @inheritDoc
     */
    public function validate(array $data): void
    {
        if (!$this->isFloat->isValid($data['price'])) {
            throw new InvalidRequestDataException(__('Price is invalid.'));
        }
    }
}
