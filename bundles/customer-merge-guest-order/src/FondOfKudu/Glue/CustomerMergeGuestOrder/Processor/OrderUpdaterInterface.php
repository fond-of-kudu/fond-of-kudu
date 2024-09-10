<?php

namespace FondOfKudu\Glue\CustomerMergeGuestOrder\Processor;

use Generated\Shared\Transfer\CustomerTransfer;

interface OrderUpdaterInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function updateGuestOrder(CustomerTransfer $customerTransfer): void;
}
