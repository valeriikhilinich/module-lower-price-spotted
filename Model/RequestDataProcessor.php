<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Model;

use Magento\Framework\Escaper;
use ValeriiKhilinich\LowerPriceSpotted\Exception\InvalidRequestDataException;

class RequestDataProcessor
{
    /**
     * @param ValidatorsPool $validatorsPool
     * @param Escaper $escaper
     */
    public function __construct(
        private readonly ValidatorsPool $validatorsPool,
        private readonly Escaper $escaper,
    ) {
    }

    /**
     * Validate and sanitize request data.
     *
     * @param array $data
     * @return array
     * @throws InvalidRequestDataException
     */
    public function processData(array $data): array
    {
        $this->validateData($data);

        return $this->sanitizeData($data);
    }

    /**
     * Run custom validators for the requested data.
     *
     * @param array $data
     *
     * @return void
     *
     * @throws InvalidRequestDataException
     */
    private function validateData(array $data): void
    {
        foreach ($this->validatorsPool->getValidators() as $validator) {
            $validator->validate($data);
        }
    }

    /**
     * Clean data from bad customer request.
     *
     * @param array $data
     * @return array
     */
    private function sanitizeData(array $data): array
    {
        unset($data['form_key']);

        $this->filterCompetitorData($data);

        foreach ($data as &$value) {
            $value = $this->escaper->escapeHtml($value);
        }

        return $data;
    }

    /**
     * Remove competitor links or description at once, giving priority to the referrer URL.
     * This is necessary to leave only one source.
     *
     * @param array $data
     * @return void
     */
    private function filterCompetitorData(array &$data): void
    {
        if (!isset($data['source'])) {
            return;
        }

        $data[$data['source'] === 'url' ? 'description' : 'url'] = null;

        unset($data['source']);
    }
}
