<?php

namespace FondOfKudu\Zed\OmsRetryCaptureProcess\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;

interface OmsRetryCatpureProcessToPayoneFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isCaptureApproved(OrderTransfer $orderTransfer): bool;
}
