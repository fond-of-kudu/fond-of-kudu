<?php

namespace FondOfKudu\Zed\OmsOrderConfirmation\Business;

use Codeception\Test\Unit;
use FondOfKudu\Zed\OmsOrderConfirmation\Business\Mail\RevocationPolicyMailExpander;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class OmsOrderConfirmationFacadeTest extends Unit
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
     * @var \FondOfKudu\Zed\OmsOrderConfirmation\Business\Mail\RevocationPolicyMailExpander|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RevocationPolicyMailExpander|MockObject $revocationPolicyMailExpanderMock;

    protected OmsOrderConfirmationBusinessFactory|MockObject $omsOrderConfirmationBusinessFactoryMock;

    /**
     * @var \FondOfKudu\Zed\OmsOrderConfirmation\Business\OmsOrderConfirmationFacade
     */
    protected OmsOrderConfirmationFacade $omsOrderConfirmationFacade;

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

        $this->revocationPolicyMailExpanderMock = $this->getMockBuilder(RevocationPolicyMailExpander::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->omsOrderConfirmationBusinessFactoryMock = $this->getMockBuilder(OmsOrderConfirmationBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->omsOrderConfirmationFacade = new OmsOrderConfirmationFacade();
        $this->omsOrderConfirmationFacade->setFactory($this->omsOrderConfirmationBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testExpandOrderMailTransfer(): void
    {
        $this->omsOrderConfirmationBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createRevocationPolicyMailExpander')
            ->willReturn($this->revocationPolicyMailExpanderMock);

        $this->revocationPolicyMailExpanderMock->expects(static::atLeastOnce())
            ->method('expandOrderMailTransfer')
            ->with($this->mailTransferMock, $this->orderTransferMock)
            ->willReturn($this->mailTransferMock);

        static::assertEquals($this->mailTransferMock, $this->omsOrderConfirmationFacade->expandOrderMailTransfer(
            $this->mailTransferMock,
            $this->orderTransferMock,
        ));
    }
}
