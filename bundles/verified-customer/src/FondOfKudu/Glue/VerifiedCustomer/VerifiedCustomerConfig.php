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
    public const CUSTOMER_ALREADY_VERIFIED_CODE = '2';

    /**
     * @var string
     */
    public const CUSTOMER_NOT_VERIFIED_ERROR_DETAIL = 'Customer is not verified.';

    /**
     * @var string
     */
    public const CUSTOMER_ALREADY_VERIFIED_DETAIL = 'Customer is already verified.';

    /**
     * @var string
     */
    public const CONTROLLER_CUSTOMER_VERIFICATION_RESEND = 'customer-verification-resend-resource';

    /**
     * @var string
     */
    public const RESOURCE_CUSTOMER_VERIFICATION_RESEND = 'customer-verification-resend';

    /**
     * @var string
     */
    public const RESOURCE_CUSTOMERS = 'customers';

    /**
     * @return array<string>
     */
    public function getWhiteListedResources(): array
    {
        return [
            static::RESOURCE_CUSTOMER_VERIFICATION_RESEND,
        ];
    }
}
