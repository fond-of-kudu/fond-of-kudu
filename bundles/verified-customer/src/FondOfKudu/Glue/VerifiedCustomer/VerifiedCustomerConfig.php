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
     * @var string
     */
    public const RESOURCE_CUSTOMERS = 'customers';

    /**
     * @return array
     */
    public function getWhiteListedResources(): array
    {
        return [];
    }
}
