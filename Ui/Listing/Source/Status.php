<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Ui\Listing\Source;

use Magento\Framework\Data\OptionSourceInterface;
use ValeriiKhilinich\LowerPriceSpotted\Model\RequestStatus;

class Status implements OptionSourceInterface
{
    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => RequestStatus::REQUESTED->value,
                'label' => __('Requested'),
            ],
            [
                'value' => RequestStatus::APPROVED->value,
                'label' => __('Approved'),
            ],
            [
                'value' => RequestStatus::REJECTED->value,
                'label' => __('Rejected'),
            ],
        ];
    }
}
