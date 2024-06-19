<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerRestorePasswordInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function restorePassword(CustomerTransfer $customerTransfer): CustomerResponseTransfer;
}
