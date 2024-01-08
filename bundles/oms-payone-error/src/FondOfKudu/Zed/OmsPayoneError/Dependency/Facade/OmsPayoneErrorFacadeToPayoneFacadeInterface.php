<?php

namespace FondOfKudu\Zed\OmsPayoneError\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;

interface OmsPayoneErrorFacadeToPayoneFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isCaptureApproved(OrderTransfer $orderTransfer): bool;
}
