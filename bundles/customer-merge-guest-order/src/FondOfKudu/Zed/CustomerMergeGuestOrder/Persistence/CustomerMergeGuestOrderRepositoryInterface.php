<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence;

use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerMergeGuestOrderRepositoryInterface
{
    /**
     * @param string $email
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomerByCustomerReference(string $email): ?CustomerTransfer;
}
