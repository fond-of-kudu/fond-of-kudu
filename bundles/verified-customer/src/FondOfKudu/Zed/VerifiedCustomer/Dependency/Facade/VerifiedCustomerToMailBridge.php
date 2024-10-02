<?php

namespace FondOfKudu\Zed\VerifiedCustomer\Dependency\Facade;

use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

class VerifiedCustomerToMailBridge implements VerifiedCustomerToMailInterface
{
    /**
     * @var \Spryker\Zed\Mail\Business\MailFacadeInterface
     */
    protected MailFacadeInterface $mailFacade;

    /**
     * @param \Spryker\Zed\Mail\Business\MailFacadeInterface $mailFacade
     */
    public function __construct(MailFacadeInterface $mailFacade)
    {
        $this->mailFacade = $mailFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function handleMail(MailTransfer $mailTransfer): void
    {
        $this->mailFacade->handleMail($mailTransfer);
    }
}
