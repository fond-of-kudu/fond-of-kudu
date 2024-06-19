<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class CustomerPasswordUpdatedAtConnectorConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    protected const CUSTOMER_PASSWORD_EXPIRATION_PERIOD = '+2 hours';

    /**
     * @var bool
     */
    protected const PASSWORD_RESET_EXPIRATION_IS_ENABLED = false;

    /**
     * Specification:
     * - Toggles the password reset expiration.
     * - It is enabled by default.
     *
     * @api
     *
     * @return bool
     */
    public function isCustomerPasswordResetExpirationEnabled(): bool
    {
        return static::PASSWORD_RESET_EXPIRATION_IS_ENABLED;
    }

    /**
     * Specification:
     * - Returns a time string that must be compatible with https://www.php.net/manual/en/datetime.modify.php that is used to check if the password reset has been expired.
     * - The default is 2h hours.
     *
     * @api
     *
     * @return string
     */
    public function getCustomerPasswordResetExpirationPeriod(): string
    {
        return static::CUSTOMER_PASSWORD_EXPIRATION_PERIOD;
    }
}
