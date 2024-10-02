<?php

namespace FondOfKudu\Zed\VerifiedCustomer\Dependency\Facade;

use Generated\Shared\Transfer\MailTransfer;

interface VerifiedCustomerToMailInterface
{
    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function handleMail(MailTransfer $mailTransfer): void;
}
