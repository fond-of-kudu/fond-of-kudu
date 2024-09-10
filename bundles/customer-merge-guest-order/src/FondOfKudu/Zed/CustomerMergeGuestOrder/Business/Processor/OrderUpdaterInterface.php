<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Business\Processor;

use Generated\Shared\Transfer\CustomerMergeGuestOrderResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface OrderUpdaterInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerMergeGuestOrderResponseTransfer
     */
    public function updateGuestOrder(CustomerTransfer $customerTransfer): CustomerMergeGuestOrderResponseTransfer;
}
