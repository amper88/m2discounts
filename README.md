# m2discounts

## This module is to show up the ways of how can we get custom discounts on our Magento store.

### Installation
- Clone the project on your magento root directory. The module Amper/Discounts needs to be inside your app/code directory.
- Remove your static assets => rm -rf var/view_preprocessed/* pub/static/frontend/* var/cache/*
- Remove your generated Magento directory => rm -rf generated/*
- run the following commands:
  - php bin/magento setup:upgrade
  - php bin/magento setup:di:compile
  - php bin/magento s:s:d -f (if you are on production mode)
  - php bin/magento ca:fl

### Configuration
You need to get logged into your Magento admin panel, and go into Stores > Configuration > AMPer > Discounts, in there you will find all the corresponding parameters to get this module configured as your preferences.
- Enabled: By default the module is enabled, you can disable that if needed and it wont be shown anymore.
- QTY item to get discount: This is the amount of a certain SKU that we need to reach, in order to get applied the discount on the next parameter. By default its 5.
- Amount of discount per item: This is a percentage of discount applied to the subtotal of a certain item in the cart, that its applied if the qty of previous parameter is reached. By default is 10%.
- Total cart amount to reach discount: This is the amount that we need to reach on the whole cart subtotal, in order to get a 2nd discount applied, stablished by the next parameter. By default is 1000.
- Total cart discount: This is the percentage of discount that will be applied to the whole cart subtotal, if the amount of the previous parameter was reached. By default is 5.