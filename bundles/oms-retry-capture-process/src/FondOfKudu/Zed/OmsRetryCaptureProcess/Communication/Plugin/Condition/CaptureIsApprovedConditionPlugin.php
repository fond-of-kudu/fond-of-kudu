<?php

namespace FondOfKudu\Zed\OmsRetryCaptureProcess\Communication\Plugin\Condition;

use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Payone\Communication\Plugin\Oms\Condition\AbstractPlugin;

/**
 * @method \FondOfKudu\Zed\OmsRetryCaptureProcess\Communication\OmsRetryCaptureProcessCommunicationFactory getFactory()
 * @method \FondOfKudu\Zed\OmsRetryCaptureProcess\OmsRetryCaptureProcessConfig getConfig()
 */
class CaptureIsApprovedConditionPlugin extends AbstractPlugin
{
    /**
     * @var string
     */
    public const NAME = 'CaptureIsApprovedPlugin';

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return bool
     */
    protected function callFacade(OrderTransfer $orderTransfer): bool
    {
        if (in_array($orderTransfer->getCustomer()->getEmail(), $this->getConfig()->getCaptureFailTestRecipients())) {
            return false;
        }

        return $this->getFactory()->getPayoneFacade()->isCaptureApproved($orderTransfer);
    }
}
