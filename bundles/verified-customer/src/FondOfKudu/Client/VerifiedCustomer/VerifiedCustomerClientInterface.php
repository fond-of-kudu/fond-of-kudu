<?php

namespace FondOfKudu\Client\VerifiedCustomer;

use Generated\Shared\Transfer\CustomerTransfer;

interface VerifiedCustomerClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\VerifiedCustomerResponseTransfer
     */
    public function resendAccountVerification(CustomerTransfer $customerTransfer): VerifiedCustomerResponseTransfer;
}