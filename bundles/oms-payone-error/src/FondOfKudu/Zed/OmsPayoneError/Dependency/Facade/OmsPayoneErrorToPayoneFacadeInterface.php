<?php

namespace FondOfKudu\Zed\OmsPayoneError\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;

interface OmsPayoneErrorToPayoneFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isCaptureApproved(OrderTransfer $orderTransfer): bool;
}
