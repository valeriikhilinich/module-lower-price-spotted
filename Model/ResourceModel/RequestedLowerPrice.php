<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class RequestedLowerPrice extends AbstractDb
{
    public const string TABLE_NAME = 'requested_lower_price';
    public const string ID_FIELD = 'request_id';

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, self::ID_FIELD);
    }
}
