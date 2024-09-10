<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence;

use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerMergeGuestOrderEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return bool
     */
    public function updateGuestOrder(CustomerTransfer $customerTransfer): bool;
}
