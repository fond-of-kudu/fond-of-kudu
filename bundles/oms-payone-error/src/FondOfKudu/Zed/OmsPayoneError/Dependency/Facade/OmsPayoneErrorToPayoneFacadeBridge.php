<?php

namespace FondOfKudu\Zed\OmsPayoneError\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Payone\Business\PayoneFacadeInterface;

class OmsPayoneErrorToPayoneFacadeBridge implements OmsPayoneErrorToPayoneFacadeInterface
{
    private PayoneFacadeInterface $payoneFacade;

    /**
     * @param \SprykerEco\Zed\Payone\Business\PayoneFacadeInterface $payoneFacade
     */
    public function __construct(PayoneFacadeInterface $payoneFacade)
    {
        $this->payoneFacade = $payoneFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    public function isCaptureApproved(OrderTransfer $orderTransfer): bool
    {
        return $this->payoneFacade->isCaptureApproved($orderTransfer);
    }
}
