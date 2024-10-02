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
        $fallback = $this->getHostYves() . '/register/confirm?token=%s';

        return sprintf($this->get(VerifiedCustomerConstants::REGISTRATION_CONFIRMATION_TOKEN_URL, $fallback), $token);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getHostYves(): string
    {
        return $this->get(VerifiedCustomerConstants::BASE_URL_YVES);
    }
}
