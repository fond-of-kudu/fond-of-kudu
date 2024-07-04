<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client;

use Codeception\Test\Unit;
use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorClient;
use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorClientInterface
     */
    protected MockObject|CustomerPasswordUpdatedAtConnectorClientInterface $customerPasswordUpdatedAtConnectorClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Dependency\Client\CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface
     */
    protected CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientInterface $customerPasswordUpdateAtConnectorClientBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerPasswordUpdatedAtConnectorClientMock = $this->createMock(CustomerPasswordUpdatedAtConnectorClient::class);
        $this->customerTransferMock = $this->createMock(CustomerTransfer::class);
        $this->customerPasswordUpdateAtConnectorClientBridge = new CustomersRestApiConnectorToCustomerPasswordUpdateAtConnectorClientBridge(
            $this->customerPasswordUpdatedAtConnectorClientMock,
        );
    }

    /**
     * @return void
     */
    public function testRestorePassword(): void
    {
        $this->customerPasswordUpdatedAtConnectorClientMock->expects(static::once())
            ->method('restorePassword')
            ->with($this->customerTransferMock);

        $this->customerPasswordUpdateAtConnectorClientBridge->restorePassword($this->customerTransferMock);
    }

    /**
     * @return void
     */
    public function testPasswordUpdated(): void
    {
        $this->customerPasswordUpdatedAtConnectorClientMock->expects(static::once())
            ->method('passwordUpdated')
            ->with($this->customerTransferMock);

        $this->customerPasswordUpdateAtConnectorClientBridge->passwordUpdated($this->customerTransferMock);
    }
}
