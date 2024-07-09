<?php

namespace FondOfKudu\Zed\CustomerPasswordChangedAtConnector\Business\Customer;

use Codeception\Test\Unit;
use DateTime;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerPasswordUpdated;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerPasswordUpdatedInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorConfig;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerBridge;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface;
use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomer;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Customer\Business\Exception\CustomerNotFoundException;

class CustomerPasswordUpdatedTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerBridge
     */
    protected MockObject|CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerBridge $queryContainerBridgeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorConfig
     */
    protected MockObject|CustomerPasswordUpdatedAtConnectorConfig $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer
     */
    protected MockObject|CustomerPasswordUpdatedResponseTransfer $customerPasswordUpdatedResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    protected MockObject|SpyCustomerQuery $spyCustomerQueryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Customer\Persistence\SpyCustomer
     */
    protected MockObject|SpyCustomer $spyCustomerMock;

    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerPasswordUpdatedInterface
     */
    protected CustomerPasswordUpdatedInterface $customerPasswordUpdated;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->queryContainerBridgeMock = $this->createMock(CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerBridge::class);
        $this->configMock = $this->createMock(CustomerPasswordUpdatedAtConnectorConfig::class);
        $this->customerPasswordUpdatedResponseTransferMock = $this->createMock(CustomerPasswordUpdatedResponseTransfer::class);
        $this->customerTransferMock = $this->createMock(CustomerTransfer::class);
        $this->spyCustomerQueryMock = $this->createMock(SpyCustomerQuery::class);
        $this->spyCustomerMock = $this->createMock(SpyCustomer::class);

        $this->customerPasswordUpdated = new class (
            $this->queryContainerBridgeMock,
            $this->configMock,
            $this->customerPasswordUpdatedResponseTransferMock
        ) extends CustomerPasswordUpdated {
            /**
             * @var \Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer
             */
            protected CustomerPasswordUpdatedResponseTransfer $customerPasswordUpdatedResponseTransfer;

            /**
             * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface $customerQueryContainer
             * @param \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorConfig $config
             * @param \Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer $customerPasswordUpdatedResponseTransfer
             */
            public function __construct(
                CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface $customerQueryContainer,
                CustomerPasswordUpdatedAtConnectorConfig $config,
                CustomerPasswordUpdatedResponseTransfer $customerPasswordUpdatedResponseTransfer
            ) {
                parent::__construct($customerQueryContainer, $config);

                $this->customerPasswordUpdatedResponseTransfer = $customerPasswordUpdatedResponseTransfer;
            }

            /**
             * @param bool $isSuccess
             * @param bool $accountExists
             *
             * @return \Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer
             */
            protected function createCustomerPasswordUpdatedResponseTransfer(
                bool $isSuccess = true,
                bool $accountExists = true
            ): CustomerPasswordUpdatedResponseTransfer {
                $this->customerPasswordUpdatedResponseTransfer->setIsSuccess($isSuccess);
                $this->customerPasswordUpdatedResponseTransfer->setAccountExists($accountExists);

                return $this->customerPasswordUpdatedResponseTransfer;
            }
        };
    }

    /**
     * @return void
     */
    public function testPasswordUpdatedIsUpdatedGetCustomerById(): void
    {
        // start: customer query
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(99);

        $this->queryContainerBridgeMock->expects(static::atLeastOnce())
            ->method('queryCustomerById')
            ->with(99)
            ->willReturn($this->spyCustomerQueryMock);

        $this->spyCustomerQueryMock->expects(static::atLeastOnce())
            ->method('findOne')
            ->willReturn($this->spyCustomerMock);
        // end: customer query

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $limit = new DateTime('2024-01-01');
        $updatedAt = clone($limit->modify('+30 day'));

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('getPasswordUpdatedAt')
            ->willReturn($updatedAt);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getCustomerUpdateLimit')
            ->willReturn($limit);

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('setIsUpdated')
            ->with(true)
            ->willReturnSelf();

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('setUpdatedAt')
            ->with($updatedAt->format('Y-m-d H:i:s'))
            ->willReturnSelf();

        $customerPasswordUpdatedResponseTransfer = $this->customerPasswordUpdated->passwordUpdated($this->customerTransferMock);

        static::assertEquals($customerPasswordUpdatedResponseTransfer, $this->customerPasswordUpdatedResponseTransferMock);
    }

    /**
     * @return void
     */
    public function testPasswordUpdatedIsUpdatedGetCustomerByEmail(): void
    {
        // start: customer query
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getEmail')
            ->willReturn('test@foobar.com');

        $this->queryContainerBridgeMock->expects(static::atLeastOnce())
            ->method('queryCustomerByEmail')
            ->with('test@foobar.com')
            ->willReturn($this->spyCustomerQueryMock);

        $this->spyCustomerQueryMock->expects(static::atLeastOnce())
            ->method('findOne')
            ->willReturn($this->spyCustomerMock);
        // end: customer query

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $limit = new DateTime('2024-01-01');
        $updatedAt = clone($limit->modify('+30 day'));

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('getPasswordUpdatedAt')
            ->willReturn($updatedAt);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getCustomerUpdateLimit')
            ->willReturn($limit);

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('setIsUpdated')
            ->with(true)
            ->willReturnSelf();

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('setUpdatedAt')
            ->with($updatedAt->format('Y-m-d H:i:s'))
            ->willReturnSelf();

        $customerPasswordUpdatedResponseTransfer = $this->customerPasswordUpdated->passwordUpdated($this->customerTransferMock);

        static::assertEquals($customerPasswordUpdatedResponseTransfer, $this->customerPasswordUpdatedResponseTransferMock);
    }

    /**
     * @return void
     */
    public function testPasswordUpdatedIsUpdatedGetCustomerByRestoreKey(): void
    {
        // start: customer query
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getRestorePasswordKey')
            ->willReturn('restore-key');

        $this->queryContainerBridgeMock->expects(static::atLeastOnce())
            ->method('queryCustomerByRestorePasswordKey')
            ->with('restore-key')
            ->willReturn($this->spyCustomerQueryMock);

        $this->spyCustomerQueryMock->expects(static::atLeastOnce())
            ->method('findOne')
            ->willReturn($this->spyCustomerMock);
        // end: customer query

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $limit = new DateTime('2024-01-01');
        $updatedAt = clone($limit->modify('+30 day'));

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('getPasswordUpdatedAt')
            ->willReturn($updatedAt);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getCustomerUpdateLimit')
            ->willReturn($limit);

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('setIsUpdated')
            ->with(true)
            ->willReturnSelf();

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('setUpdatedAt')
            ->with($updatedAt->format('Y-m-d H:i:s'))
            ->willReturnSelf();

        $customerPasswordUpdatedResponseTransfer = $this->customerPasswordUpdated->passwordUpdated($this->customerTransferMock);

        static::assertEquals($customerPasswordUpdatedResponseTransfer, $this->customerPasswordUpdatedResponseTransferMock);
    }

    /**
     * @return void
     */
    public function testPasswordUpdatedIsNotUpdatedGetCustomerByRestoreKey(): void
    {
        // start: customer query
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getRestorePasswordKey')
            ->willReturn('restore-key');

        $this->queryContainerBridgeMock->expects(static::atLeastOnce())
            ->method('queryCustomerByRestorePasswordKey')
            ->with('restore-key')
            ->willReturn($this->spyCustomerQueryMock);

        $this->spyCustomerQueryMock->expects(static::atLeastOnce())
            ->method('findOne')
            ->willReturn($this->spyCustomerMock);
        // end: customer query

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $limit = new DateTime('2024-01-01');

        $this->spyCustomerMock->expects(static::atLeastOnce())
            ->method('getPasswordUpdatedAt')
            ->willReturn(null);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getCustomerUpdateLimit')
            ->willReturn($limit);

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('setIsUpdated')
            ->with(false)
            ->willReturnSelf();

        $this->customerPasswordUpdatedResponseTransferMock->expects(static::atLeastOnce())
            ->method('setUpdatedAt')
            ->with(null)
            ->willReturnSelf();

        $customerPasswordUpdatedResponseTransfer = $this->customerPasswordUpdated->passwordUpdated($this->customerTransferMock);

        static::assertEquals($customerPasswordUpdatedResponseTransfer, $this->customerPasswordUpdatedResponseTransferMock);
    }

    /**
     * @return void
     */
    public function testPasswordUpdatedAccountNotFound(): void
    {
        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(99);

        $this->queryContainerBridgeMock->expects(static::atLeastOnce())
            ->method('queryCustomerById')
            ->with(99)
            ->willThrowException(new CustomerNotFoundException());

        $customerPasswordUpdatedResponseTransfer = $this->customerPasswordUpdated->passwordUpdated($this->customerTransferMock);

        static::assertEquals($customerPasswordUpdatedResponseTransfer, $this->customerPasswordUpdatedResponseTransferMock);
    }
}
