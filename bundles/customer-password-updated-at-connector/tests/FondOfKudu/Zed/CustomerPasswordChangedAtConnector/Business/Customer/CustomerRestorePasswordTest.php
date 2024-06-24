<?php

namespace FondOfKudu\Zed\CustomerPasswordChangedAtConnector\Business\Customer;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Checker\PasswordResetExpirationChecker;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Checker\PasswordResetExpirationCheckerInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerRestorePassword;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerRestorePasswordInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerExpander\CustomerExpander;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerExpander\CustomerExpanderInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeBridge;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerBridge;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\Country\Persistence\SpyCountry;
use Orm\Zed\Customer\Persistence\SpyCustomer;
use Orm\Zed\Customer\Persistence\SpyCustomerAddress;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use PHPUnit\Framework\MockObject\MockObject;
use Propel\Runtime\Collection\ObjectCollection;
use ReflectionClass;
use ReflectionMethod;

class CustomerRestorePasswordTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface
     */
    protected MockObject|CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface $customerQueryContainerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Checker\PasswordResetExpirationCheckerInterface
     */
    protected MockObject|PasswordResetExpirationCheckerInterface $passwordResetExpirationCheckerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerExpander\CustomerExpanderInterface
     */
    protected MockObject|CustomerExpanderInterface $customerExpanderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerResponseTransfer
     */
    protected MockObject|CustomerResponseTransfer $customerResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeInterface
     */
    protected MockObject|CustomerPasswordUpdatedAtConnectorMailFacadeInterface $mailFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    protected MockObject|SpyCustomerQuery $spyCustomerQueryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Customer\Persistence\SpyCustomer
     */
    protected MockObject|SpyCustomer $spyCustomerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Customer\Persistence\SpyCustomerAddress
     */
    protected MockObject|SpyCustomerAddress $spyCustomerAddressMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Country\Persistence\SpyCountry
     */
    protected MockObject|SpyCountry $spyCountryMock;

    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerRestorePasswordInterface
     */
    protected CustomerRestorePasswordInterface $customerRestorePassword;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerQueryContainerMock = $this->createMock(CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerBridge::class);
        $this->passwordResetExpirationCheckerMock = $this->createMock(PasswordResetExpirationChecker::class);
        $this->customerExpanderMock = $this->createMock(CustomerExpander::class);
        $this->mailFacadeMock = $this->createMock(CustomerPasswordUpdatedAtConnectorMailFacadeBridge::class);
        $this->customerTransferMock = $this->createMock(CustomerTransfer::class);
        $this->customerResponseTransferMock = $this->createMock(CustomerResponseTransfer::class);
        $this->spyCustomerQueryMock = $this->createMock(SpyCustomerQuery::class);
        $this->spyCustomerMock = $this->createMock(SpyCustomer::class);
        $this->spyCustomerAddressMock = $this->createMock(SpyCustomerAddress::class);
        $this->spyCountryMock = $this->createMock(SpyCountry::class);

        $this->customerRestorePassword = new class (
            $this->customerQueryContainerMock,
            $this->passwordResetExpirationCheckerMock,
            $this->customerExpanderMock,
            $this->mailFacadeMock,
            $this->customerResponseTransferMock
        ) extends CustomerRestorePassword {
            /**
             * @var \Generated\Shared\Transfer\CustomerResponseTransfer
             */
            protected CustomerResponseTransfer $customerResponseTransfer;

            /**
             * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface $customerQueryContainer
             * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Checker\PasswordResetExpirationCheckerInterface $passwordResetExpirationChecker
             * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerExpander\CustomerExpanderInterface $customerExpander
             * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeInterface $mailFacade
             * @param \Generated\Shared\Transfer\CustomerResponseTransfer $customerResponseTransfer
             */
            public function __construct(
                CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface $customerQueryContainer,
                PasswordResetExpirationCheckerInterface $passwordResetExpirationChecker,
                CustomerExpanderInterface $customerExpander,
                CustomerPasswordUpdatedAtConnectorMailFacadeInterface $mailFacade,
                CustomerResponseTransfer $customerResponseTransfer
            ) {
                parent::__construct(
                    $customerQueryContainer,
                    $passwordResetExpirationChecker,
                    $customerExpander,
                    $mailFacade,
                );

                $this->customerResponseTransfer = $customerResponseTransfer;
            }

            /**
             * @param bool $isSuccess
             *
             * @return \Generated\Shared\Transfer\CustomerResponseTransfer
             */
            protected function createCustomerResponseTransfer(bool $isSuccess = true): CustomerResponseTransfer
            {
                return $this->customerResponseTransfer;
            }
        };
    }

    /**
     * @return void
     */
    public function testRestorePasswordSuccessWithIdCustomer(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getPassword')
            ->willReturn('password');

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setPassword')
            ->willReturnSelf();

        // start: id customer query
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(99);

        $this->customerQueryContainerMock->expects(static::atLeastOnce())
            ->method('queryCustomerById')
            ->with(99)
            ->willReturn($this->spyCustomerQueryMock);

        $this->spyCustomerQueryMock->expects(static::atLeastOnce())
            ->method('findOne')
            ->willReturn($this->spyCustomerMock);
        // end: id customer query

        $this->passwordResetExpirationCheckerMock->expects(static::atLeastOnce())
            ->method('checkPasswordResetExpiration')
            ->with($this->spyCustomerMock, $this->customerResponseTransferMock)
            ->willReturn($this->customerResponseTransferMock);

        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('setRestorePasswordDate')
            ->with(null)
            ->willReturnSelf();

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('setRestorePasswordKey')
            ->with(null)
            ->willReturnSelf();

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('save');

        $addressEntityCollection = new class ([$this->spyCustomerAddressMock]) extends ObjectCollection {
            /**
             * @param array $data
             */
            public function __construct(array $data = [])
            {
                parent::__construct($data);
            }

            /**
             * @param $object
             *
             * @return string
             */
            protected function getHashCode($object): string
            {
                return 'hash';
            }
        };

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('getAddresses')
            ->willReturn($addressEntityCollection);

        $this->spyCustomerAddressMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->spyCustomerAddressMock->expects(static::atLeastOnce())
            ->method('getCountry')
            ->willReturn($this->spyCountryMock);

        $this->spyCountryMock->expects(static::atLeastOnce())
            ->method('getIso2Code')
            ->willReturn('DE');

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('getDefaultBillingAddress')
            ->willReturn(100);

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('getDefaultShippingAddress')
            ->willReturn(100);

        $this->spyCustomerAddressMock->expects(static::atLeastOnce())
            ->method('getIdCustomerAddress')
            ->willReturn(100);

        $this->customerExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $customerResponseTransfer = $this->customerRestorePassword->restorePassword($this->customerTransferMock);

        static::assertEquals($customerResponseTransfer, $this->customerResponseTransferMock);
    }

    /**
     * @return void
     */
    public function testRestorePasswordSuccessWithEmailCustomer(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getPassword')
            ->willReturn('password');

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setPassword')
            ->willReturnSelf();

        // start: id customer query
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn('test@foobar.com');

        $this->customerQueryContainerMock->expects(static::atLeastOnce())
            ->method('queryCustomerByEmail')
            ->with('test@foobar.com')
            ->willReturn($this->spyCustomerQueryMock);

        $this->spyCustomerQueryMock->expects(static::atLeastOnce())
            ->method('findOne')
            ->willReturn($this->spyCustomerMock);
        // end: id customer query

        $this->passwordResetExpirationCheckerMock->expects(static::atLeastOnce())
            ->method('checkPasswordResetExpiration')
            ->with($this->spyCustomerMock, $this->customerResponseTransferMock)
            ->willReturn($this->customerResponseTransferMock);

        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('setRestorePasswordDate')
            ->with(null)
            ->willReturnSelf();

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('setRestorePasswordKey')
            ->with(null)
            ->willReturnSelf();

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('save');

        $addressEntityCollection = new class ([$this->spyCustomerAddressMock]) extends ObjectCollection {
            /**
             * @param array $data
             */
            public function __construct(array $data = [])
            {
                parent::__construct($data);
            }

            /**
             * @param $object
             *
             * @return string
             */
            protected function getHashCode($object): string
            {
                return 'hash';
            }
        };

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('getAddresses')
            ->willReturn($addressEntityCollection);

        $this->spyCustomerAddressMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->spyCustomerAddressMock->expects(static::atLeastOnce())
            ->method('getCountry')
            ->willReturn($this->spyCountryMock);

        $this->spyCountryMock->expects(static::atLeastOnce())
            ->method('getIso2Code')
            ->willReturn('DE');

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('getDefaultBillingAddress')
            ->willReturn(100);

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('getDefaultShippingAddress')
            ->willReturn(100);

        $this->spyCustomerAddressMock->expects(static::atLeastOnce())
            ->method('getIdCustomerAddress')
            ->willReturn(100);

        $this->customerExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $customerResponseTransfer = $this->customerRestorePassword->restorePassword($this->customerTransferMock);

        static::assertEquals($customerResponseTransfer, $this->customerResponseTransferMock);
    }

    /**
     * @return void
     */
    public function testRestorePasswordSuccessWithRestorePasswordKey(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getPassword')
            ->willReturn('password');

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setPassword')
            ->willReturnSelf();

        // start: id customer query
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getRestorePasswordKey')
            ->willReturn('asdf');

        $this->customerQueryContainerMock->expects(static::atLeastOnce())
            ->method('queryCustomerByRestorePasswordKey')
            ->with('asdf')
            ->willReturn($this->spyCustomerQueryMock);

        $this->spyCustomerQueryMock->expects(static::atLeastOnce())
            ->method('findOne')
            ->willReturn($this->spyCustomerMock);
        // end: id customer query

        $this->passwordResetExpirationCheckerMock->expects(static::atLeastOnce())
            ->method('checkPasswordResetExpiration')
            ->with($this->spyCustomerMock, $this->customerResponseTransferMock)
            ->willReturn($this->customerResponseTransferMock);

        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('setRestorePasswordDate')
            ->with(null)
            ->willReturnSelf();

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('setRestorePasswordKey')
            ->with(null)
            ->willReturnSelf();

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('save');

        $addressEntityCollection = new class ([$this->spyCustomerAddressMock]) extends ObjectCollection {
            /**
             * @param array $data
             */
            public function __construct(array $data = [])
            {
                parent::__construct($data);
            }

            /**
             * @param $object
             *
             * @return string
             */
            protected function getHashCode($object): string
            {
                return 'hash';
            }
        };

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('getAddresses')
            ->willReturn($addressEntityCollection);

        $this->spyCustomerAddressMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->spyCustomerAddressMock->expects(static::atLeastOnce())
            ->method('getCountry')
            ->willReturn($this->spyCountryMock);

        $this->spyCountryMock->expects(static::atLeastOnce())
            ->method('getIso2Code')
            ->willReturn('DE');

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('getDefaultBillingAddress')
            ->willReturn(100);

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('getDefaultShippingAddress')
            ->willReturn(100);

        $this->spyCustomerAddressMock->expects(static::atLeastOnce())
            ->method('getIdCustomerAddress')
            ->willReturn(100);

        $this->customerExpanderMock->expects(static::atLeastOnce())
            ->method('expand')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $customerResponseTransfer = $this->customerRestorePassword->restorePassword($this->customerTransferMock);

        static::assertEquals($customerResponseTransfer, $this->customerResponseTransferMock);
    }

    /**
     * @return void
     */
    public function testRestorePasswordFailedCustomerNotFound(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getPassword')
            ->willReturn('password');

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('setPassword')
            ->willReturnSelf();

        // start: id customer query
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getRestorePasswordKey')
            ->willReturn('asdf');

        $this->customerQueryContainerMock->expects(static::atLeastOnce())
            ->method('queryCustomerByRestorePasswordKey')
            ->with('asdf')
            ->willReturn($this->spyCustomerQueryMock);

        $this->spyCustomerQueryMock->expects(static::atLeastOnce())
            ->method('findOne')
            ->willReturn(null);
        // end: id customer query

        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('setIsSuccess')
            ->with(false)
            ->willReturnSelf();

        $this->customerResponseTransferMock->expects(static::atLeastOnce())
            ->method('addError')
            ->willReturnSelf();

        $customerResponseTransfer = $this->customerRestorePassword->restorePassword($this->customerTransferMock);

        static::assertEquals($customerResponseTransfer, $this->customerResponseTransferMock);
    }

    /**
     * @param string $name
     *
     * @return \ReflectionMethod
     */
    protected function getReflectionMethodByName(string $name): ReflectionMethod
    {
        $reflectionClass = new ReflectionClass(PasswordResetExpirationChecker::class);

        $reflectionMethod = $reflectionClass->getMethod($name);
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod;
    }
}
