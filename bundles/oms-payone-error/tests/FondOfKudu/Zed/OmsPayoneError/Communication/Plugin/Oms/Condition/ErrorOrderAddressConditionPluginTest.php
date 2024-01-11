<?php

namespace FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Oms\Condition;

use Codeception\Test\Unit;
use FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorRepository;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use PHPUnit\Framework\MockObject\MockObject;

class ErrorOrderAddressConditionPluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Oms\Condition\ErrorOrderAddressConditionPlugin
     */
    protected ErrorOrderAddressConditionPlugin $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Sales\Persistence\SpySalesOrderItem
     */
    protected MockObject|SpySalesOrderItem $spySalesOrderItemMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorRepository
     */
    protected MockObject|OmsPayoneErrorRepository $omsPayoneErrorRepositoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->spySalesOrderItemMock = $this->getMockBuilder(SpySalesOrderItem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->omsPayoneErrorRepositoryMock = $this->getMockBuilder(OmsPayoneErrorRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ErrorOrderAddressConditionPlugin();
    }

    /**
     * @return void
     */
    public function testCheckTrue(): void
    {
        $this->omsPayoneErrorRepositoryMock->expects(static::atLeastOnce())
            ->method('findPaymentPayoneApiLogErrorWithIdSalesOrder')
            ->with(699)
            ->willReturn('50');

        static::assertTrue($this->plugin->check($this->spySalesOrderItemMock));
    }

    /**
     * @return void
     */
    public function testCheckFalse(): void
    {
        $this->omsPayoneErrorRepositoryMock->expects(static::atLeastOnce())
            ->method('findPaymentPayoneApiLogErrorWithIdSalesOrder')
            ->with(699)
            ->willReturn('9999');

        static::assertTrue($this->plugin->check($this->spySalesOrderItemMock));
    }
}
