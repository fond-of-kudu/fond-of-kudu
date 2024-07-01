<?php

namespace FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Zed;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerPasswordUpdatedResponseTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class CustomerPasswordUpdatedAtConnectorStubTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected MockObject|ZedRequestClientInterface $zedStubMock;

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
     * @var \FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Zed\CustomerPasswordUpdatedAtConnectorStubInterface
     */
    protected CustomerPasswordUpdatedAtConnectorStubInterface $customerPasswordUpdatedAtConnectorStub;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->zedStubMock = $this->createMock(ZedRequestClientInterface::class);
        $this->customerTransferMock = $this->createMock(CustomerTransfer::class);
        $this->customerResponseTransferMock = $this->createMock(CustomerResponseTransfer::class);
        $this->customerPasswordUpdatedResponseTransferMock = $this->createMock(CustomerPasswordUpdatedResponseTransfer::class);
        $this->customerPasswordUpdatedAtConnectorStub = new CustomerPasswordUpdatedAtConnectorStub($this->zedStubMock);
    }

    /**
     * @return void
     */
    public function testRestorePassword(): void
    {
        $this->zedStubMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                '/customer-password-updated-at-connector/gateway/restore-password',
                $this->customerTransferMock,
            )
            ->willReturn($this->customerResponseTransferMock);

        static::assertEquals(
            $this->customerPasswordUpdatedAtConnectorStub->restorePassword($this->customerTransferMock),
            $this->customerResponseTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testPasswordUpdated(): void
    {
        $this->zedStubMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                '/customer-password-updated-at-connector/gateway/password-updated',
                $this->customerTransferMock,
            )
            ->willReturn($this->customerPasswordUpdatedResponseTransferMock);

        static::assertEquals(
            $this->customerPasswordUpdatedAtConnectorStub->passwordUpdated($this->customerTransferMock),
            $this->customerPasswordUpdatedResponseTransferMock,
        );
    }
}
