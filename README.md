# Magento 2 Module: Lower Price Spotted

Module ValeriiKhilinich_LowerPriceSpotted implements the “Lower Price Detected” feature, allowing customers to submit price comparison requests directly from product pages. An intuitive admin interface has been developed to manage incoming requests with automatic product price updates upon approval, streamlining pricing operations and improving customer engagement.
## 🔧 Installation

### Using Composer

```bash
composer require valerii-khilinich/module-lower-price-spotted
bin/magento module:enable ValeriiKhilinich_LowerPriceSpotted
bin/magento setup:upgrade
bin/magento cache:flush
```

### Enable functionality

1. To use this extension, go to ``Stores -> Settings -> Catalog -> Lower Price Detected -> General -> Enable`` and set it to "Yes".
2. After that, clear the cache, and you will be able to use the modules' functionality. 

## Extensibility features
This module provides the ability to add custom validators for data requests, as this is a security purpose to avoid invalid requests from the client.
To add your own validator, follow these steps:
1. Create a validator class and implement [ValidatorInterface](./Api/ValidatorInterface.php) as a validator module for the corresponding validator definition.
2. Add validator to [ValidatorsPool](./Model/ValidatorsPool.php) via di.xml, as in [module](./etc/di.xml).
