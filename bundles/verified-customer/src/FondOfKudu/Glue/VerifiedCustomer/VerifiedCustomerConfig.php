<?php

namespace FondOfKudu\Glue\VerifiedCustomer;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class VerifiedCustomerConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const CUSTOMER_NOT_VERIFIED_ERROR_CODE = '1';

    /**
     * @return array<string>
     */
    public function getResourcesToBlock(): array
    {
        return [
            'customers',
            'addresses',
            'carts',
            'cart-items',
            'wishlists',
            'wishlist-items',
            'orders',
        ];
    }
}
