<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Ui\Listing\DataProvider;

use Magento\Framework\Api\Filter;
use Magento\Ui\DataProvider\AbstractDataProvider;
use ValeriiKhilinich\LowerPriceSpotted\Api\Data\RequestedLowerPriceInterface;
use ValeriiKhilinich\LowerPriceSpotted\Model\ResourceModel\RequestedLowerPrice\CollectionFactory;

class RequestsLowerPriceDataProvider extends AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create();
    }

    /**
     * @inheritDoc
     */
    public function addFilter(Filter $filter): void
    {
        if ($filter->getField() == 'competitor_reference') {
            $this->addFilterByReferences($filter);

            return;
        }

        parent::addFilter($filter);
    }

    /**
     * Add a filter to filter by competitor URL and description.
     *
     * @param Filter $filter
     * @return void
     */
    private function addFilterByReferences(Filter $filter): void
    {
        $this->getCollection()->addFieldToFilter(
            [RequestedLowerPriceInterface::REFERENCE_URL, RequestedLowerPriceInterface::COMPETITOR_DESCRIPTION],
            [
                [$filter->getConditionType() => $filter->getValue()],
                [$filter->getConditionType() => $filter->getValue()]
            ]
        );
    }
}
