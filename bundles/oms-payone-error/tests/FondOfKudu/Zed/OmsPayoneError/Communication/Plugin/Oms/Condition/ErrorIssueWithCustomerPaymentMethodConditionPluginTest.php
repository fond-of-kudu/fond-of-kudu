<?php

namespace FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Oms\Condition;

use Codeception\Test\Unit;
use FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorRepository;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use PHPUnit\Framework\MockObject\MockObject;

class ErrorIssueWithCustomerPaymentMethodConditionPluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Oms\Condition\ErrorIssueWithCustomerPaymentMethodConditionPlugin
     */
    protected ErrorIssueWithCustomerPaymentMethodConditionPlugin $plugin;

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

        $this->plugin = new ErrorIssueWithCustomerPaymentMethodConditionPlugin();
        $this->plugin->setRepository($this->omsPayoneErrorRepositoryMock);
    }

    /**
     * @return void
     */
    public function testCheckTrue(): void
    {
        $this->omsPayoneErrorRepositoryMock->expects(static::atLeastOnce())
            ->method('findPaymentPayoneApiLogErrorWithIdSalesOrder')
            ->with('699')
            ->willReturn('50');

        $this->spySalesOrderItemMock->expects(static::atLeastOnce())
            ->method('getFkSalesOrder')
            ->willReturn('699');

        static::assertTrue($this->plugin->check($this->spySalesOrderItemMock));
    }

    /**
     * @return void
     */
    public function testCheckFalse(): void
    {
        $this->omsPayoneErrorRepositoryMock->expects(static::atLeastOnce())
            ->method('findPaymentPayoneApiLogErrorWithIdSalesOrder')
            ->with('699')
            ->willReturn('9999');

        $this->spySalesOrderItemMock->expects(static::atLeastOnce())
            ->method('getFkSalesOrder')
            ->willReturn('699');

        static::assertFalse($this->plugin->check($this->spySalesOrderItemMock));
    }

    /**
     * @return void
     */
    public function testCheckNull(): void
    {
        $this->omsPayoneErrorRepositoryMock->expects(static::atLeastOnce())
            ->method('findPaymentPayoneApiLogErrorWithIdSalesOrder')
            ->with('699')
            ->willReturn(null);

        $this->spySalesOrderItemMock->expects(static::atLeastOnce())
            ->method('getFkSalesOrder')
            ->willReturn('699');

        static::assertFalse($this->plugin->check($this->spySalesOrderItemMock));
    }
}
