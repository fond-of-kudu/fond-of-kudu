<?php

namespace FondOfKudu\Zed\JellyfishKletties\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfKudu\Zed\JellyfishKletties\Communication\JellyfishKlettiesCommunicationFactory;
use FondOfKudu\Zed\JellyfishKletties\Dependency\Facade\JellyfishKlettiesToKlettiesFacadeBridge;
use Generated\Shared\Transfer\JellyfishOrderTransfer;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrder;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class JellyfishKlettiesOrderExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\JellyfishKletties\Communication\Plugin\JellyfishKlettiesOrderExpanderPlugin
     */
    protected $plugin;

    /**
     * @var \Orm\Zed\Sales\Persistence\SpySalesOrder|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $salesOrderMock;

    /**
     * @var \Generated\Shared\Transfer\JellyfishOrderTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $jellyOrderTransferMock;

    /**
     * @var \Orm\Zed\Kletties\Persistence\FokKlettiesOrder|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesOrderMock;

    /**
     * @var \FondOfKudu\Zed\JellyfishKletties\Communication\JellyfishKlettiesCommunicationFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $factoryMock;

    /**
     * @var \FondOfKudu\Zed\JellyfishKletties\Dependency\Facade\JellyfishKlettiesToKlettiesFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
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
        $this->salesOrderMock = $this->getMockBuilder(SpySalesOrder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->jellyOrderTransferMock = $this->getMockBuilder(JellyfishOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesOrderMock = $this->getMockBuilder(FokKlettiesOrder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(JellyfishKlettiesCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(JellyfishKlettiesToKlettiesFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesOrderTransferMock = $this->getMockBuilder(KlettiesOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new JellyfishKlettiesOrderExpanderPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->salesOrderMock->expects($this->once())->method('getFokKlettiesOrder')->willReturn($this->klettiesOrderMock);
        $this->factoryMock->expects($this->once())->method('getKlettiesFacade')->willReturn($this->facadeMock);
        $this->facadeMock->expects($this->once())->method('convertKlettiesOrderEntityToTransfer')->willReturn($this->klettiesOrderTransferMock);
        $this->jellyOrderTransferMock->expects($this->once())->method('setKlettiesOrder');

        $this->plugin->expand($this->jellyOrderTransferMock, $this->salesOrderMock);
    }

    /**
     * @return void
     */
    public function testExpandNoKlettiesOrder(): void
    {
        $this->salesOrderMock->expects($this->once())->method('getFokKlettiesOrder');
        $this->factoryMock->expects($this->never())->method('getKlettiesFacade');
        $this->facadeMock->expects($this->never())->method('convertKlettiesOrderEntityToTransfer');
        $this->jellyOrderTransferMock->expects($this->never())->method('setKlettiesOrder');

        $this->plugin->expand($this->jellyOrderTransferMock, $this->salesOrderMock);
    }
}
