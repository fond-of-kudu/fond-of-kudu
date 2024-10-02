<?php

namespace FondOfKudu\Zed\VerifiedCustomer\Persistence;

use Generated\Shared\Transfer\CustomerTransfer;

interface VerifiedCustomerRepositoryInterface
{
    /**
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomerByCustomerReference(string $customerReference): ?CustomerTransfer;
}
