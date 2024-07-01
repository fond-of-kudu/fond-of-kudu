<?php

namespace FondOfKudu\Zed\CustomerPasswordChangedAtConnector\Business;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerPasswordUpdatedInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerRestorePasswordInterface;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerPasswordUpdatedAtConnectorBusinessFactory;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerPasswordUpdatedAtConnectorFacade;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerPasswordUpdatedAtConnectorFacadeInterface;
use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerPasswordUpdatedAtConnectorFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerResponseTransfer
     */
    protected MockObject|CustomerResponseTransfer $customerResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer
     */
    protected MockObject|CustomerPasswordUpdatedResponseTransfer $customerPasswordUpdatedResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerPasswordUpdatedAtConnectorBusinessFactory
     */
    protected MockObject|CustomerPasswordUpdatedAtConnectorBusinessFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerRestorePasswordInterface
     */
    protected MockObject|CustomerRestorePasswordInterface $customerRestorePasswordMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\Customer\CustomerPasswordUpdatedInterface
     */
    protected MockObject|CustomerPasswordUpdatedInterface $customerPasswordUpdatedMock;

    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Business\CustomerPasswordUpdatedAtConnectorFacadeInterface
     */
    protected CustomerPasswordUpdatedAtConnectorFacadeInterface $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerTransferMock = $this->createMock(CustomerTransfer::class);
        $this->customerResponseTransferMock = $this->createMock(CustomerResponseTransfer::class);
        $this->customerPasswordUpdatedResponseTransferMock = $this->createMock(CustomerPasswordUpdatedResponseTransfer::class);
        $this->factoryMock = $this->createMock(CustomerPasswordUpdatedAtConnectorBusinessFactory::class);
        $this->customerRestorePasswordMock = $this->createMock(CustomerRestorePasswordInterface::class);
        $this->customerPasswordUpdatedMock = $this->createMock(CustomerPasswordUpdatedInterface::class);
        $this->facade = (new CustomerPasswordUpdatedAtConnectorFacade())->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testRestorePassword(): void
    {
        $this->factoryMock->expects(self::once())
            ->method('createCustomerRestorePassword')
            ->willReturn($this->customerRestorePasswordMock);

        $this->customerRestorePasswordMock->expects(self::once())
            ->method('restorePassword')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerResponseTransferMock);

        static::assertEquals(
            $this->facade->restorePassword($this->customerTransferMock),
            $this->customerResponseTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testPasswordUpdated(): void
    {
        $this->factoryMock->expects(self::once())
            ->method('createCustomerPasswordUpdated')
            ->willReturn($this->customerPasswordUpdatedMock);

        $this->customerPasswordUpdatedMock->expects(self::once())
            ->method('passwordUpdated')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerPasswordUpdatedResponseTransferMock);

        static::assertEquals(
            $this->facade->passwordUpdated($this->customerTransferMock),
            $this->customerPasswordUpdatedResponseTransferMock,
        );
    }
}
