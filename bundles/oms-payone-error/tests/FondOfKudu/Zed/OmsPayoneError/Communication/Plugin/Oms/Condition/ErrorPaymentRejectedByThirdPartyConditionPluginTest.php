<?php

namespace FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Oms\Condition;

use Codeception\Test\Unit;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use PHPUnit\Framework\MockObject\MockObject;

class ErrorPaymentRejectedByThirdPartyConditionPluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Oms\Condition\ErrorPaymentRejectedByThirdPartyConditionPlugin
     */
    protected ErrorPaymentRejectedByThirdPartyConditionPlugin $plugin;

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

        $this->plugin = new ErrorPaymentRejectedByThirdPartyConditionPlugin();
    }

    /**
     * @return void
     */
    public function testCheckTrue(): void
    {
        static::assertTrue($this->plugin->check($this->spySalesOrderItemMock));
    }
}
