<?php

namespace FondOfKudu\Zed\OmsOrderConfirmation\Business\Mail;

use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;

interface RevocationPolicyMailExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\MailTransfer
     */
    public function expandOrderMailTransfer(MailTransfer $mailTransfer, OrderTransfer $orderTransfer): MailTransfer;
}
