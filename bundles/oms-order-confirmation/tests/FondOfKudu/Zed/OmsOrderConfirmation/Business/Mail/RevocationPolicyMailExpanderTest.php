<?php

namespace FondOfKudu\Zed\OmsOrderConfirmation\Business\Mail;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfKudu\Zed\OmsOrderConfirmation\OmsOrderConfirmationConfig;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\MailAttachmentTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RevocationPolicyMailExpanderTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\OmsOrderConfirmation\OmsOrderConfirmationConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected OmsOrderConfirmationConfig|MockObject $confirmationConfigMock;

    /**
     * @var \Generated\Shared\Transfer\MailTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MailTransfer|MockObject $mailTransferMock;

    /**
     * @var \Generated\Shared\Transfer\MailAttachmentTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MailAttachmentTransfer|MockObject $mailAttachmentTransferMock;

    /**
     * @var \Generated\Shared\Transfer\OrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected OrderTransfer|MockObject $orderTransferMock;

    /**
     * @var \Generated\Shared\Transfer\LocaleTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected LocaleTransfer|MockObject $localeTransfer;

    /**
     * @var \FondOfKudu\Zed\OmsOrderConfirmation\Business\Mail\RevocationPolicyMailExpander
     */
    protected RevocationPolicyMailExpander $revocationPolicyMailExpander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->confirmationConfigMock = $this->getMockBuilder(OmsOrderConfirmationConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailTransferMock = $this->getMockBuilder(MailTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mailAttachmentTransferMock = $this->getMockBuilder(MailAttachmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderTransferMock = $this->getMockBuilder(OrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeTransfer = $this->getMockBuilder(LocaleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->revocationPolicyMailExpander = new RevocationPolicyMailExpander($this->confirmationConfigMock);
    }

    /**
     * @return void
     */
    public function testExpandOrderMailTransferNoLocaleKey(): void
    {
        $this->confirmationConfigMock->expects(static::atLeastOnce())
            ->method('getRevocationPolicyUrl')
            ->willReturn(['PL' => 'pathToFile']);

        $this->mailTransferMock->expects(static::atLeastOnce())
            ->method('getLocale')
            ->willReturn($this->localeTransfer);

        $this->localeTransfer->expects(static::atLeastOnce())
            ->method('getLocaleName')
            ->willReturn('DE');

        $this->mailTransferMock->expects(static::never())
            ->method('getAttachments');

        $mailTransfer = $this->revocationPolicyMailExpander->expandOrderMailTransfer(
            $this->mailTransferMock,
            $this->orderTransferMock,
        );

        static::assertEquals($mailTransfer, $this->mailTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandOrderMailTransferFileNotExists(): void
    {
        $this->confirmationConfigMock->expects(static::atLeastOnce())
            ->method('getRevocationPolicyUrl')
            ->willReturn(['DE' => 'pathToFile']);

        $this->mailTransferMock->expects(static::atLeastOnce())
            ->method('getLocale')
            ->willReturn($this->localeTransfer);

        $this->localeTransfer->expects(static::atLeastOnce())
            ->method('getLocaleName')
            ->willReturn('DE');

        $this->mailTransferMock->expects(static::never())
            ->method('getAttachments');

        $mailTransfer = $this->revocationPolicyMailExpander->expandOrderMailTransfer(
            $this->mailTransferMock,
            $this->orderTransferMock,
        );

        static::assertEquals($mailTransfer, $this->mailTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandOrderMailTransfer(): void
    {
        $mailAttachments = new ArrayObject();

        $this->confirmationConfigMock->expects(static::atLeastOnce())
            ->method('getRevocationPolicyUrl')
            ->willReturn(['DE' => './bundles/oms-order-confirmation/tests/_data/Widerrufsrecht_kids.pdf']);

        $this->mailTransferMock->expects(static::atLeastOnce())
            ->method('getLocale')
            ->willReturn($this->localeTransfer);

        $this->localeTransfer->expects(static::atLeastOnce())
            ->method('getLocaleName')
            ->willReturn('DE');

        $this->mailTransferMock->expects(static::atLeastOnce())
            ->method('getAttachments')
            ->willReturn($mailAttachments);

        $mailAttachments->append($this->mailAttachmentTransferMock);

        $this->mailTransferMock->expects(static::atLeastOnce())
            ->method('setAttachments')
            ->willReturn($mailAttachments)
            ->willReturnSelf();

        $mailTransfer = $this->revocationPolicyMailExpander->expandOrderMailTransfer(
            $this->mailTransferMock,
            $this->orderTransferMock,
        );

        static::assertEquals($mailTransfer, $this->mailTransferMock);
    }
}
