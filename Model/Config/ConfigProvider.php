<?php

namespace ValeriiKhilinich\LowerPriceSpotted\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigProvider
{
    public const SECTION_CODE = 'lower_price_spotted';
    public const XPATH_GENERAL_GROUP = self::SECTION_CODE . '/general';
    public const XPATH_MODULE_ENABLED = self::XPATH_GENERAL_GROUP . '/enabled';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(private readonly ScopeConfigInterface $scopeConfig)
    {
    }

    /**
     * Checks whether module is enabled.
     *
     * @param int|null $store
     * @return bool
     */
    public function isEnabled(?int $store = null): bool
    {
        return $this->scopeConfig->isSetFlag(self::XPATH_MODULE_ENABLED, ScopeInterface::SCOPE_STORE, $store);
    }
}
