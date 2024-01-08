<?php

namespace FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Condition;

use Codeception\Test\Unit;
use FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Oms\Condition\ErrorIssueWithCustomerPaymentMethodConditionPlugin;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

class ErrorCustomerIssuePaymentMethodConditionPluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Oms\Condition\ErrorIssueWithCustomerPaymentMethodConditionPlugin|\Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface
     */
    protected ErrorIssueWithCustomerPaymentMethodConditionPlugin|ConditionInterface $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Sales\Persistence\SpySalesOrderItem
     */
    protected MockObject|SpySalesOrderItem $spySalesOrderItemMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->spySalesOrderItemMock = $this->getMockBuilder(SpySalesOrderItem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ErrorIssueWithCustomerPaymentMethodConditionPlugin();
    }

    /**
     * @return void
     */
    public function testCheckTrue(): void
    {
        static::assertTrue($this->plugin->check($this->spySalesOrderItemMock));
    }
}
