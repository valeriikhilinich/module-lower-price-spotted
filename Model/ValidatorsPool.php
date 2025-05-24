<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Model;

use ValeriiKhilinich\LowerPriceSpotted\Api\ValidatorInterface;

class ValidatorsPool
{
    /**
     * @param ValidatorInterface[] $validators
     */
    public function __construct(private readonly array $validators = [])
    {
        foreach ($this->validators as $validator) {
            if (!$validator instanceof ValidatorInterface) {
                throw new \InvalidArgumentException('Validator must implement %1', ValidatorInterface::class);
            }
        }
    }

    /**
     * Get all registered validators.
     *
     * @return array
     */
    public function getValidators(): array
    {
        return $this->validators;
    }
}
