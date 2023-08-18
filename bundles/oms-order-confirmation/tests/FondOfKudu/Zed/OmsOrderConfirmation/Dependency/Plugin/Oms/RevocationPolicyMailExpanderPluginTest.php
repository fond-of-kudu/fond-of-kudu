<?php

namespace FondOfKudu\Zed\OmsOrderConfirmation\Dependency\Plugin\Oms;

use Codeception\Test\Unit;
use FondOfKudu\Zed\OmsOrderConfirmation\Business\OmsOrderConfirmationFacade;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RevocationPolicyMailExpanderPluginTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\MailTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MailTransfer|MockObject $mailTransferMock;

    /**
     * @var \Generated\Shared\Transfer\OrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected OrderTransfer|MockObject $orderTransferMock;

    /**
     * @var \FondOfKudu\Zed\OmsOrderConfirmation\Business\OmsOrderConfirmationFacade|\PHPUnit\Framework\MockObject\MockObject
     */
    protected OmsOrderConfirmationFacade|MockObject $omsOrderConfirmationFacadeMock;

    /**
     * @var \FondOfKudu\Zed\OmsOrderConfirmation\Dependency\Plugin\Oms\RevocationPolicyMailExpanderPlugin
     */
    protected RevocationPolicyMailExpanderPlugin $revocationPolicyMailExpanderPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->mailTransferMock = $this->getMockBuilder(MailTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderTransferMock = $this->getMockBuilder(OrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->omsOrderConfirmationFacadeMock = $this->getMockBuilder(OmsOrderConfirmationFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->revocationPolicyMailExpanderPlugin = new RevocationPolicyMailExpanderPlugin();
        $this->revocationPolicyMailExpanderPlugin->setFacade($this->omsOrderConfirmationFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->omsOrderConfirmationFacadeMock->expects(static::atLeastOnce())
            ->method('expandOrderMailTransfer')
            ->with($this->mailTransferMock, $this->orderTransferMock)
            ->willReturn($this->mailTransferMock);

        static::assertEquals($this->mailTransferMock, $this->revocationPolicyMailExpanderPlugin->expand(
            $this->mailTransferMock,
            $this->orderTransferMock,
        ));
    }
}
