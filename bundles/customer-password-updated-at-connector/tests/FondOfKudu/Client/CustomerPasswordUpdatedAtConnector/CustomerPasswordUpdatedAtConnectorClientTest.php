<?php

namespace FondOfKudu\Client\CustomerPasswordUpdatedAtConnector;

use Codeception\Test\Unit;
use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Zed\CustomerPasswordUpdatedAtConnectorStub;
use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerPasswordUpdatedAtConnectorClientTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorFactory
     */
    protected MockObject|CustomerPasswordUpdatedAtConnectorFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Zed\CustomerPasswordUpdatedAtConnectorStub
     */
    protected MockObject|CustomerPasswordUpdatedAtConnectorStub $customerPasswordUpdatedAtConnectorStubMock;

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
     * @var \FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorClient
     */
    protected CustomerPasswordUpdatedAtConnectorClient $client;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->createMock(CustomerPasswordUpdatedAtConnectorFactory::class);
        $this->customerPasswordUpdatedAtConnectorStubMock = $this->createMock(CustomerPasswordUpdatedAtConnectorStub::class);
        $this->customerTransferMock = $this->createMock(CustomerTransfer::class);
        $this->customerResponseTransferMock = $this->createMock(CustomerResponseTransfer::class);
        $this->customerPasswordUpdatedResponseTransferMock = $this->createMock(CustomerPasswordUpdatedResponseTransfer::class);
        $this->client = new CustomerPasswordUpdatedAtConnectorClient();
        $this->client->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testRestorePassword(): void
    {
        $this->factoryMock->expects(static::once())
            ->method('createZedCustomerStub')
            ->willReturn($this->customerPasswordUpdatedAtConnectorStubMock);

        $this->customerPasswordUpdatedAtConnectorStubMock->expects(static::once())
            ->method('restorePassword')
            ->willReturn($this->customerResponseTransferMock);

        static::assertEquals(
            $this->client->restorePassword($this->customerTransferMock),
            $this->customerResponseTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testPasswordUpdated(): void
    {
        $this->factoryMock->expects(static::once())
            ->method('createZedCustomerStub')
            ->willReturn($this->customerPasswordUpdatedAtConnectorStubMock);

        $this->customerPasswordUpdatedAtConnectorStubMock->expects(static::once())
            ->method('passwordUpdated')
            ->willReturn($this->customerPasswordUpdatedResponseTransferMock);

        static::assertEquals(
            $this->client->passwordUpdated($this->customerTransferMock),
            $this->customerPasswordUpdatedResponseTransferMock,
        );
    }
}
