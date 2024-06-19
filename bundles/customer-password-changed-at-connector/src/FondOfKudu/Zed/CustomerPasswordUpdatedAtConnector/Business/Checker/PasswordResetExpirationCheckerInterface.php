<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Checker;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomer;

interface PasswordResetExpirationCheckerInterface
{
    /**
     * @param \Orm\Zed\Customer\Persistence\SpyCustomer$customerEntity
     * @param \Generated\Shared\Transfer\CustomerResponseTransfer $customerResponseTransfer
     *
     * @throws \RuntimeException
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function checkPasswordResetExpiration(
        SpyCustomer $customerEntity,
        CustomerResponseTransfer $customerResponseTransfer
    ): CustomerResponseTransfer;
}
