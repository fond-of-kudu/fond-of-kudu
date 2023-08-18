<?php

namespace FondOfKudu\Zed\OmsOrderConfirmation\Business;

use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\OmsOrderConfirmation\Business\OmsOrderConfirmationBusinessFactory getFactory()
 */
class OmsOrderConfirmationFacade extends AbstractFacade implements OmsOrderConfirmationFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\MailTransfer
     */
    public function expandOrderMailTransfer(MailTransfer $mailTransfer, OrderTransfer $orderTransfer): MailTransfer
    {
        return $this->getFactory()
            ->createRevocationPolicyMailExpander()
            ->expandOrderMailTransfer($mailTransfer, $orderTransfer);
    }
}
