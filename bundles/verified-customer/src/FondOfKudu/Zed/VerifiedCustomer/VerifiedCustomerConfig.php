<?php

namespace FondOfKudu\Zed\VerifiedCustomer;

use FondOfKudu\Shared\VerifiedCustomer\VerifiedCustomerConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class VerifiedCustomerConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const CUSTOMER_REGISTRATION_WITH_CONFIRMATION_MAIL_TYPE = 'customer registration confirmation mail';

    /**
     * Specification:
     * - Provides a registration confirmation token url.
     *
     * @api
     *
     * @param string $token
     *
     * @return string
     */
    public function getRegisterConfirmTokenUrl(string $token): string
    {
        return sprintf($this->get(VerifiedCustomerConstants::REGISTRATION_CONFIRMATION_TOKEN_URL), $token);
    }
}
