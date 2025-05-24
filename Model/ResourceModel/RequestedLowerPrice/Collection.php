<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Model\ResourceModel\RequestedLowerPrice;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use ValeriiKhilinich\LowerPriceSpotted\Model\RequestedLowerPrice as RequestedLowerPriceModel;
use ValeriiKhilinich\LowerPriceSpotted\Model\ResourceModel\RequestedLowerPrice as RequestedLowerPriceResource;

class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init(RequestedLowerPriceModel::class, RequestedLowerPriceResource::class);
    }

    /**
     * @inheritDoc
     */
    protected function _initSelect(): self
    {
        parent::_initSelect();

        $this->getSelect()->joinLeft(
            'catalog_product_entity',
            'main_table.product_id = catalog_product_entity.entity_id',
            ['sku']
        );

        return $this;
    }
}
