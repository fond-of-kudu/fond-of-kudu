<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Checker;

use DateTime;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorConfig;
use Generated\Shared\Transfer\CustomerErrorTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomer;
use Spryker\Zed\Customer\CustomerConfig;

class PasswordResetExpirationChecker implements PasswordResetExpirationCheckerInterface
{
    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorConfig
     */
    protected CustomerPasswordUpdatedAtConnectorConfig $config;

    /**
     * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorConfig $config
     */
    public function __construct(CustomerPasswordUpdatedAtConnectorConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Orm\Zed\Customer\Persistence\SpyCustomer$customerEntity
     * @param \Generated\Shared\Transfer\CustomerResponseTransfer $customerResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function checkPasswordResetExpiration(
        SpyCustomer $customerEntity,
        CustomerResponseTransfer $customerResponseTransfer
    ): CustomerResponseTransfer {
        if (!$this->config->isCustomerPasswordResetExpirationEnabled()) {
            return $customerResponseTransfer
                ->setIsSuccess(true);
        }

        /** @var \DateTime|string|null $restorePasswordDate */
        $restorePasswordDate = $customerEntity->getRestorePasswordDate();

        if (!$restorePasswordDate) {
            return $customerResponseTransfer;
        }

        if (is_string($restorePasswordDate)) {
            $restorePasswordDate = new DateTime($restorePasswordDate);
        }

        $expirationDate = clone $restorePasswordDate;
        $expirationDate->modify($this->config->getCustomerPasswordResetExpirationPeriod());
        $now = new DateTime();

        if ($now < $expirationDate) {
            return $customerResponseTransfer;
        }

        $customerErrorTransfer = (new CustomerErrorTransfer())->setMessage(CustomerConfig::GLOSSARY_KEY_CONFIRM_EMAIL_LINK_INVALID_OR_USED);

        return $customerResponseTransfer
            ->setIsSuccess(false)
            ->addError($customerErrorTransfer);
    }
}
