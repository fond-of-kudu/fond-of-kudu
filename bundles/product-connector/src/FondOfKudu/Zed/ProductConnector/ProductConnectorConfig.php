<?php

namespace FondOfKudu\Zed\ProductConnector;

use FondOfKudu\Shared\ProductConnector\ProductConnectorConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class ProductConnectorConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getPriceDimensionRrp(): string
    {
        return $this->get(
            ProductConnectorConstants::PRICE_DIMENSION_RRP,
            ProductConnectorConstants::PRICE_ORIGINAL,
        );
    }

    /**
     * @return string
     */
    public function getPriceDimensionSale(): string
    {
        return $this->get(
            ProductConnectorConstants::PRICE_DIMENSION_SALE,
            ProductConnectorConstants::PRICE_DEFAULT,
        );
    }
}
