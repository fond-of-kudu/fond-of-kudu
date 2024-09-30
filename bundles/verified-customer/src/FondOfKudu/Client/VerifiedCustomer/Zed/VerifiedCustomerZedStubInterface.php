<?php

namespace FondOfKudu\Client\VerifiedCustomer\Zed;

use Generated\Shared\Transfer\CustomerTransfer;

interface VerifiedCustomerZedStubInterface
{
 /**
  * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
  *
  * @return \Generated\Shared\Transfer\VerifiedCustomerResponseTransfer
  */
    public function resendAccountVerification(CustomerTransfer $customerTransfer): VerifiedCustomerResponseTransfer;
}
