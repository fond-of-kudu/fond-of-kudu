<?php

namespace FondOfKudu\Zed\VerifiedCustomer\Business\Processor;

use FondOfKudu\Zed\VerifiedCustomer\Persistence\VerifiedCustomerRepositoryInterface;
use FondOfKudu\Zed\VerifiedCustomer\VerifiedCustomerConfig;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\VerifiedCustomerResponseTransfer;
use Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException;
use Spryker\Zed\Customer\Dependency\Facade\VerifiedCustomerToMailInterface;

class Mailer implements MailerInterface
{
    /**
     * @var \FondOfKudu\Zed\VerifiedCustomer\Persistence\VerifiedCustomerRepositoryInterface
     */
    protected VerifiedCustomerRepositoryInterface $repository;

    /**
     * @var \Spryker\Zed\Customer\Dependency\Facade\VerifiedCustomerToMailInterface
     */
    protected VerifiedCustomerToMailInterface $mailFacade;

    /**
     * @var \FondOfKudu\Zed\VerifiedCustomer\VerifiedCustomerConfig
     */
    protected VerifiedCustomerConfig $verifiedCustomerConfig;

    /**
     * @param \FondOfKudu\Zed\VerifiedCustomer\VerifiedCustomerConfig $verifiedCustomerConfig
     * @param \FondOfKudu\Zed\VerifiedCustomer\Persistence\VerifiedCustomerRepositoryInterface $repository
     * @param \Spryker\Zed\Customer\Dependency\Facade\VerifiedCustomerToMailInterface $mailFacade
     */
    public function __construct(
        VerifiedCustomerConfig $verifiedCustomerConfig,
        VerifiedCustomerRepositoryInterface $repository,
        VerifiedCustomerToMailInterface $mailFacade
    ) {
        $this->repository = $repository;
        $this->mailFacade = $mailFacade;
        $this->verifiedCustomerConfig = $verifiedCustomerConfig;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\VerifiedCustomerResponseTransfer
     */
    public function resendAccountVerification(CustomerTransfer $customerTransfer): VerifiedCustomerResponseTransfer
    {
        try {
            $customerTransfer->requireCustomerReference();
        } catch (RequiredTransferPropertyException $e) {
            return (new VerifiedCustomerResponseTransfer())->setIsSuccess(false);
        }

        $customerTransfer = $this->repository->getCustomerByCustomerReference($customerTransfer->getCustomerReference());

        if ($customerTransfer === null || $customerTransfer->getRegistrationKey() === null) {
            return (new VerifiedCustomerResponseTransfer())->setIsSuccess(false);
        }

        $this->sendRegistrationToken($customerTransfer);

        return (new VerifiedCustomerResponseTransfer())->setIsSuccess(true);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return bool
     */
    protected function sendRegistrationToken(CustomerTransfer $customerTransfer): bool
    {
        $confirmationLink = $this->verifiedCustomerConfig
            ->getRegisterConfirmTokenUrl(
                $customerTransfer->getRegistrationKey(),
            );

        $customerTransfer->setConfirmationLink($confirmationLink);

        $mailTransfer = new MailTransfer();
        $mailTransfer->setType(VerifiedCustomerConfig::CUSTOMER_REGISTRATION_WITH_CONFIRMATION_MAIL_TYPE);
        $mailTransfer->setCustomer($customerTransfer);
        $mailTransfer->setLocale($customerTransfer->getLocale());
        $mailTransfer->setStoreName($customerTransfer->getStoreName());

        $this->mailFacade->handleMail($mailTransfer);

        return true;
    }
}