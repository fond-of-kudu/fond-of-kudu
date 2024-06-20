<?php

namespace FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer;

use DateTime;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Checker\PasswordResetExpirationCheckerInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerExpander\CustomerExpanderInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface;
use Generated\Shared\Transfer\AddressesTransfer;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CustomerErrorTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomer;
use Orm\Zed\Customer\Persistence\SpyCustomerAddress;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Shared\Customer\Code\Messages;
use Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException;
use Spryker\Zed\Customer\Communication\Plugin\Mail\CustomerRestoredPasswordConfirmationMailTypePlugin;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class CustomerRestorePassword extends AbstractCustomerModel implements CustomerRestorePasswordInterface
{
    /**
     * @var int
     */
    protected const BCRYPT_FACTOR = 12;

    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface
     */
    protected CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface $customerQueryContainer;

    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Checker\PasswordResetExpirationCheckerInterface
     */
    protected PasswordResetExpirationCheckerInterface $passwordResetExpirationChecker;

    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerExpander\CustomerExpanderInterface
     */
    protected CustomerExpanderInterface $customerExpander;

    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeInterface
     */
    protected CustomerPasswordUpdatedAtConnectorMailFacadeInterface $mailFacade;

    /**
     * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface $customerQueryContainer
     * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Checker\PasswordResetExpirationCheckerInterface $passwordResetExpirationChecker
     * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerExpander\CustomerExpanderInterface $customerExpander
     * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeInterface $mailFacade
     */
    public function __construct(
        CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface $customerQueryContainer,
        PasswordResetExpirationCheckerInterface $passwordResetExpirationChecker,
        CustomerExpanderInterface $customerExpander,
        CustomerPasswordUpdatedAtConnectorMailFacadeInterface $mailFacade
    ) {
        $this->customerQueryContainer = $customerQueryContainer;
        $this->passwordResetExpirationChecker = $passwordResetExpirationChecker;
        $this->customerExpander = $customerExpander;
        $this->mailFacade = $mailFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function restorePassword(CustomerTransfer $customerTransfer): CustomerResponseTransfer
    {
        $customerTransfer = $this->encryptPassword($customerTransfer);

        $customerResponseTransfer = $this->createCustomerPasswordUpdatedResponseTransfer();

        try {
            $customerEntity = $this->getCustomer($customerTransfer);
        } catch (CustomerNotFoundException $e) {
            $customerError = new CustomerErrorTransfer();
            $customerError->setMessage(Messages::CUSTOMER_TOKEN_INVALID);

            $customerResponseTransfer
                ->setIsSuccess(false)
                ->addError($customerError);

            return $customerResponseTransfer;
        }

        $customerResponseTransfer = $this
            ->passwordResetExpirationChecker
            ->checkPasswordResetExpiration($customerEntity, $customerResponseTransfer);

        if (!$customerResponseTransfer->getIsSuccess()) {
            return $customerResponseTransfer;
        }

        $customerEntity->setRestorePasswordDate(null);
        $customerEntity->setRestorePasswordKey(null);

        $customerEntity->setPassword($customerTransfer->getPassword());
        $customerEntity->setPasswordUpdatedAt(new DateTime());

        $customerEntity->save();
        $customerTransfer->fromArray($customerEntity->toArray(), true);
        $this->sendPasswordRestoreConfirmation($customerTransfer);

        $customerResponseTransfer->setCustomerTransfer($customerTransfer);

        return $customerResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function get(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        $customerEntity = $this->getCustomer($customerTransfer);
        $customerTransfer->fromArray($customerEntity->toArray(), true);

        $customerTransfer = $this->attachAddresses($customerTransfer, $customerEntity);
        $customerTransfer = $this->attachLocale($customerTransfer, $customerEntity);
        $customerTransfer = $this->customerExpander->expand($customerTransfer);

        return $customerTransfer;
    }

    /**
     * @param bool $isSuccess
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    protected function createCustomerPasswordUpdatedResponseTransfer(bool $isSuccess = true): CustomerResponseTransfer
    {
        $customerResponseTransfer = new CustomerResponseTransfer();
        $customerResponseTransfer->setIsSuccess($isSuccess);

        return $customerResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param \Orm\Zed\Customer\Persistence\SpyCustomer $customerEntity
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function attachLocale(CustomerTransfer $customerTransfer, SpyCustomer $customerEntity): CustomerTransfer
    {
        $localeEntity = $customerEntity->getLocale();
        if (!$localeEntity) {
            return $customerTransfer;
        }

        $localeTransfer = new LocaleTransfer();
        $localeTransfer->fromArray($localeEntity->toArray(), true);
        $customerTransfer->setLocale($localeTransfer);

        return $customerTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param \Orm\Zed\Customer\Persistence\SpyCustomer $customerEntity
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function attachAddresses(CustomerTransfer $customerTransfer, SpyCustomer $customerEntity): CustomerTransfer
    {
        $addresses = $customerEntity->getAddresses();
        $addressesTransfer = $this->entityCollectionToTransferCollection($addresses, $customerEntity);
        $customerTransfer->setAddresses($addressesTransfer);

        $customerTransfer = $this->attachAddressesTransfer($customerTransfer, $addressesTransfer);

        return $customerTransfer;
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $addressEntities
     * @param \Orm\Zed\Customer\Persistence\SpyCustomer $customer
     *
     * @return \Generated\Shared\Transfer\AddressesTransfer
     */
    protected function entityCollectionToTransferCollection(
        ObjectCollection $addressEntities,
        SpyCustomer $customer
    ): AddressesTransfer {
        $addressCollection = new AddressesTransfer();

        foreach ($addressEntities as $address) {
            $addressTransfer = $this->entityToTransfer($address);

            if ($customer->getDefaultBillingAddress() === $address->getIdCustomerAddress()) {
                $addressTransfer->setIsDefaultBilling(true);
            }

            if ($customer->getDefaultShippingAddress() === $address->getIdCustomerAddress()) {
                $addressTransfer->setIsDefaultShipping(true);
            }

            $addressCollection->addAddress($addressTransfer);
        }

        return $addressCollection;
    }

    /**
     * @param \Orm\Zed\Customer\Persistence\SpyCustomerAddress $addressEntity
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    protected function entityToTransfer(SpyCustomerAddress $addressEntity): AddressTransfer
    {
        $addressTransfer = new AddressTransfer();
        $addressTransfer->fromArray($addressEntity->toArray(), true);
        $addressTransfer->setIso2Code($addressEntity->getCountry()->getIso2Code());

        return $addressTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param \Generated\Shared\Transfer\AddressesTransfer $addressesTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function attachAddressesTransfer(
        CustomerTransfer $customerTransfer,
        AddressesTransfer $addressesTransfer
    ): CustomerTransfer {
        foreach ($addressesTransfer->getAddresses() as $addressTransfer) {
            if ($addressTransfer->getIsDefaultBilling()) {
                $customerTransfer->addBillingAddress($addressTransfer);
            }

            if ($addressTransfer->getIsDefaultShipping()) {
                $customerTransfer->addShippingAddress($addressTransfer);
            }
        }

        return $customerTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function encryptPassword(CustomerTransfer $customerTransfer)
    {
        $currentPassword = $customerTransfer->getPassword();
        $customerTransfer->setPassword($this->getEncodedPassword($currentPassword));

        return $customerTransfer;
    }

    /**
     * @param string|null $currentPassword
     *
     * @return string|null
     */
    protected function getEncodedPassword($currentPassword): ?string
    {
        if ($currentPassword === null) {
            return $currentPassword;
        }

        return $this->createPasswordHasher()->hash($currentPassword);
    }

    /**
     * @return \Symfony\Component\PasswordHasher\PasswordHasherInterface
     */
    public function createPasswordHasher(): PasswordHasherInterface
    {
        return new NativePasswordHasher(null, null, static::BCRYPT_FACTOR);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    protected function sendPasswordRestoreConfirmation(CustomerTransfer $customerTransfer): void
    {
        $customerTransfer = $this->get($customerTransfer);

        $mailTransfer = new MailTransfer();
        $mailTransfer->setType(CustomerRestoredPasswordConfirmationMailTypePlugin::MAIL_TYPE);
        $mailTransfer->setCustomer($customerTransfer);
        $mailTransfer->setLocale($customerTransfer->getLocale());
        $mailTransfer->setStoreName($customerTransfer->getStoreName());

        $this->mailFacade->handleMail($mailTransfer);
    }
}
