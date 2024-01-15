<?php

namespace FondOfKudu\Zed\OmsRetryCaptureProcess\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\OrderTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use SprykerEco\Zed\Payone\Business\PayoneFacade;
use SprykerEco\Zed\Payone\Business\PayoneFacadeInterface;

class OmsRetryCatpureProcessToPayoneFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\SprykerEco\Zed\Payone\Business\PayoneFacadeInterface
     */
    protected MockObject|PayoneFacadeInterface $payoneFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\OrderTransfer
     */
    protected MockObject|OrderTransfer $orderTransferMock;

    /**
     * @var \FondOfKudu\Zed\OmsRetryCaptureProcess\Dependency\Facade\OmsRetryCatpureProcessToPayoneFacadeBridge
     */
    protected OmsRetryCatpureProcessToPayoneFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->payoneFacadeMock = $this->getMockBuilder(PayoneFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderTransferMock = $this->getMockBuilder(OrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new OmsRetryCatpureProcessToPayoneFacadeBridge($this->payoneFacadeMock);
    }

    /**
     * @return void
     */
    public function testIsCaptureApprovedTrue(): void
    {
        $this->payoneFacadeMock->expects(static::atLeastOnce())
            ->method('isCaptureApproved')
            ->with($this->orderTransferMock)
            ->willReturn(true);

        static::assertTrue($this->bridge->isCaptureApproved($this->orderTransferMock));
    }

    /**
     * @return void
     */
    public function testIsCaptureApprovedFalse(): void
    {
        $this->payoneFacadeMock->expects(static::atLeastOnce())
            ->method('isCaptureApproved')
            ->with($this->orderTransferMock)
            ->willReturn(false);

        static::assertFalse($this->bridge->isCaptureApproved($this->orderTransferMock));
    }
}
