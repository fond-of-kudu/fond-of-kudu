<?php

namespace FondOfKudu\Zed\OmsRetryCaptureProcess\Communication\Plugin\Condition;

use Codeception\Test\Unit;
use DateTime;
use FondOfKudu\Zed\OmsRetryCaptureProcess\OmsRetryCaptureProcessConfig;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

class RetryCaptureTimeoutConditionPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Sales\Persistence\SpySalesOrderItem
     */
    protected MockObject|SpySalesOrderItem $salesOrderItemMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Sales\Persistence\SpySalesOrder
     */
    protected MockObject|SpySalesOrder $spySalesOrderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\OmsRetryCaptureProcess\OmsRetryCaptureProcessConfig
     */
    protected MockObject|OmsRetryCaptureProcessConfig $configMock;

    /**
     * @var \Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface
     */
    protected ConditionInterface $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->salesOrderItemMock = $this->getMockBuilder(SpySalesOrderItem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spySalesOrderMock = $this->getMockBuilder(SpySalesOrder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(OmsRetryCaptureProcessConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new RetryCaptureTimeoutConditionPlugin();
        $this->plugin->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testCheckTrue(): void
    {
        $createdAt = (new DateTime())->modify('+6 hours');

        $this->salesOrderItemMock->expects(static::atLeastOnce())
            ->method('getOrder')
            ->willReturn($this->spySalesOrderMock);

        $this->spySalesOrderMock->expects(static::atLeastOnce())
            ->method('getCreatedAt')
            ->willReturn($createdAt);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getHoursAfterCaptureFinalFailed')
            ->willReturn(12);

        static::assertTrue($this->plugin->check($this->salesOrderItemMock));
    }

    /**
     * @return void
     */
    public function testCheckFalse(): void
    {
        $createdAt = (new DateTime())->modify('+16 hour');

        $this->salesOrderItemMock->expects(static::atLeastOnce())
            ->method('getOrder')
            ->willReturn($this->spySalesOrderMock);

        $this->spySalesOrderMock->expects(static::atLeastOnce())
            ->method('getCreatedAt')
            ->willReturn($createdAt);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getHoursAfterCaptureFinalFailed')
            ->willReturn(12);

        static::assertFalse($this->plugin->check($this->salesOrderItemMock));
    }
}
