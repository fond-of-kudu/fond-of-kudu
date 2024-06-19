<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade;

use Generated\Shared\Transfer\MailTransfer;

interface CustomerPasswordUpdatedAtConnectorMailFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function handleMail(MailTransfer $mailTransfer): void;
}
