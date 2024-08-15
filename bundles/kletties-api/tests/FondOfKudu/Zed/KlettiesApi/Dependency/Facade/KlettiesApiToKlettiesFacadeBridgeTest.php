<?php

namespace FondOfKudu\Zed\KlettiesApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfKudu\Zed\Kletties\Business\KlettiesFacade;
use Generated\Shared\Transfer\KlettiesOrderTransfer;

class KlettiesApiToKlettiesFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeBridge
     */
    protected $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface
     */
    protected $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\KlettiesOrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesOrderTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(KlettiesFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesOrderTransferMock = $this->getMockBuilder(KlettiesOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new KlettiesApiToKlettiesFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testUpdateKlettiesOrder(): void
    {
        $this->facadeMock->expects($this->once())
            ->method('updateKlettiesOrder')
            ->willReturn($this->klettiesOrderTransferMock);

        $this->bridge->updateKlettiesOrder($this->klettiesOrderTransferMock);
    }

    /**
     * @return void
     */
    public function testFindKlettiesOrderById(): void
    {
        $this->facadeMock->expects($this->once())
            ->method('findKlettiesOrderById')
            ->willReturn($this->klettiesOrderTransferMock);

        $this->bridge->findKlettiesOrderById(1);
    }
}
