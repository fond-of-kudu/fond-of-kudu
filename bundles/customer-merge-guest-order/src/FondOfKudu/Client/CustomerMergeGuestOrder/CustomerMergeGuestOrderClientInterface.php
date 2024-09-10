<?php

namespace FondOfKudu\Client\CustomerMergeGuestOrder;

use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerMergeGuestOrderClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function updateGuestOrder(CustomerTransfer $customerTransfer): void;
}
