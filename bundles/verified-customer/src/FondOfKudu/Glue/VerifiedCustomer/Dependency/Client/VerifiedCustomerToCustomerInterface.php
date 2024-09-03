<?php

namespace FondOfKudu\Glue\VerifiedCustomer\Dependency\Client;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface VerifiedCustomerToCustomerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return mixed
     */
    public function findCustomerByReference(CustomerTransfer $customerTransfer): CustomerResponseTransfer;
}
