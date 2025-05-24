<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Model\Validator;

use Laminas\Validator\NotEmpty;
use Laminas\Validator\Uri;
use ValeriiKhilinich\LowerPriceSpotted\Api\ValidatorInterface;
use ValeriiKhilinich\LowerPriceSpotted\Exception\InvalidRequestDataException;

class CompetitorReference implements ValidatorInterface
{
    /**
     * @param Uri $uri
     * @param NotEmpty $notEmpty
     */
    public function __construct(
        private readonly Uri $uri,
        private readonly NotEmpty $notEmpty
    ) {
    }

    /**
     * @inheritDoc
     */
    public function validate(array $data): void
    {
        if (!$data['url'] && !$data['description']) {
            throw new InvalidRequestDataException(__('Provide reference url or description to make request'));
        }

        if ($data['url'] && !$this->uri->isValid($data['url'])) {
            throw new InvalidRequestDataException(__('Provide valid reference url!'));
        }

        if ($data['description'] && !$this->notEmpty->isValid($data['description'])) {
            throw new InvalidRequestDataException(__('Provide valid reference url!'));
        }
    }
}
