<?php

namespace FondOfKudu\Zed\CheckoutRestApi;

use Spryker\Zed\CheckoutRestApi\CheckoutRestApiConfig as SprykerCheckoutRestApiConfig;

class CheckoutRestApiConfig extends SprykerCheckoutRestApiConfig
{
    /**
     * @api
     *
     * @return bool
     */
    public function deleteCartAfterOrderCreation(): bool
    {
        return false;
    }
}
