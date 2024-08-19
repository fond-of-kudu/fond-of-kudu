<?php

namespace FondOfKudu\Zed\JellyfishKletties\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfKudu\Zed\Kletties\Business\KlettiesFacade;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrder;

class JellyfishKlettiesToKlettiesFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\JellyfishKletties\Dependency\Facade\JellyfishKlettiesToKlettiesFacadeBridge
     */
    protected $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface
     */
    protected $facadeMock;

    /**
     * @var \Orm\Zed\Kletties\Persistence\FokKlettiesOrder|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesOrderMock;

    /**
     * @var \Generated\Shared\Transfer\KlettiesOrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $orderTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(KlettiesFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesOrderMock = $this->getMockBuilder(FokKlettiesOrder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderTransferMock = $this->getMockBuilder(KlettiesOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new JellyfishKlettiesToKlettiesFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testConvertKlettiesOrderEntityToTransfer(): void
    {
        $this->facadeMock->expects($this->once())
            ->method('convertKlettiesOrderEntityToTransfer')
            ->willReturn($this->orderTransferMock);

        $this->bridge->convertKlettiesOrderEntityToTransfer($this->klettiesOrderMock);
    }
}
