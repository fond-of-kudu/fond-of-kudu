<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerPasswordUpdatedInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function passwordUpdated(CustomerTransfer $customerTransfer): CustomerResponseTransfer;
}
