<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Api;

use ValeriiKhilinich\LowerPriceSpotted\Exception\InvalidRequestDataException;

interface ValidatorInterface
{
    /**
     * Implement validation logic to check data against specific conditions.
     *
     * @param array $data
     *
     * @return void
     *
     * @throws InvalidRequestDataException
     */
    public function validate(array $data): void;
}
