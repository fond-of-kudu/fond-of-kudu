<?php

namespace FondOfKudu\Glue\SecurityBlockerReset;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class SecurityBlockerResetConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const SECURITY_BLOCKER_RESET_CUSTOMER_ENTITY_TYPE = 'customer';

    /**
     * @var string
     */
    public const RESOURCE_CUSTOMER_RESTORE_PASSWORD = 'customer-restore-password';
}
