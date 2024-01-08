<?php

namespace FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Oms\Condition;

use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Payone\Communication\Plugin\Oms\Condition\AbstractPlugin;

/**
 * @method \FondOfKudu\Zed\OmsPayoneError\Communication\OmsPayoneErrorCommunicationFactory getFactory()
 * @method \FondOfKudu\Zed\OmsPayoneError\OmsPayoneErrorConfig getConfig()
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorQueryContainerInterface getQueryContainer()
 * @method \FondOfKudu\Zed\OmsPayoneError\Business\OmsPayoneErrorFacadeInterface getFacade()
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
