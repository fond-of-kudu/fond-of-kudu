<?php

namespace FondOfKudu\Zed\CustomerPasswordChangedAtConnector\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeBridge;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeInterface;
use Generated\Shared\Transfer\MailTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

class CustomerPasswordUpdatedAtConnectorMailFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Mail\Business\MailFacadeInterface
     */
    protected MockObject|MailFacadeInterface $mailFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\MailTransfer
     */
    protected MockObject|MailTransfer $mailTransferMock;

    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\Facade\CustomerPasswordUpdatedAtConnectorMailFacadeInterface
     */
    protected CustomerPasswordUpdatedAtConnectorMailFacadeInterface $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->mailFacadeMock = $this->createMock(MailFacadeInterface::class);
        $this->mailTransferMock = $this->createMock(MailTransfer::class);
        $this->bridge = new CustomerPasswordUpdatedAtConnectorMailFacadeBridge($this->mailFacadeMock);
    }

    /**
     * @return void
     */
    public function testHandleMail(): void
    {
        $this->mailFacadeMock->expects(static::once())
            ->method('handleMail')
            ->with($this->mailTransferMock);

        $this->bridge->handleMail($this->mailTransferMock);
    }
}
