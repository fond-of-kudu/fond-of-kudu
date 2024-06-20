<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector;

use FondOfKudu\Shared\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorConstants;
use Spryker\Glue\Kernel\AbstractBundleConfig;

class CustomersRestApiConnectorConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const RESOURCE_CUSTOMER_RESTORE_PASSWORD = 'customer-restore-password';

    /**
     * @var string
     */
    public const CONTROLLER_CUSTOMER_RESTORE_PASSWORD = 'customer-restore-password-resource';

    /**
     * @return string
     */
    public function getResourceCustomerRestorePassword(): string
    {
        return $this->get(
            CustomerPasswordUpdatedAtConnectorConstants::RESOURCE_CUSTOMER_RESTORE_PASSWORD_CUSTOM,
            static::RESOURCE_CUSTOMER_RESTORE_PASSWORD,
        );
    }
}
