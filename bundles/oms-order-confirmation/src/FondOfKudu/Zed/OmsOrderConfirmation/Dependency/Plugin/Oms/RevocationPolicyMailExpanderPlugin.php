<?php

namespace FondOfKudu\Zed\OmsOrderConfirmation\Dependency\Plugin\Oms;

use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\OmsExtension\Dependency\Plugin\OmsOrderMailExpanderPluginInterface;

/**
 * @method \FondOfKudu\Zed\OmsOrderConfirmation\Business\OmsOrderConfirmationFacadeInterface getFacade()
 */
class RevocationPolicyMailExpanderPlugin extends AbstractPlugin implements OmsOrderMailExpanderPluginInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\MailTransfer
     */
    public function expand(MailTransfer $mailTransfer, OrderTransfer $orderTransfer): MailTransfer
    {
        return $this->getFacade()->expandOrderMailTransfer($mailTransfer, $orderTransfer);
    }
}
