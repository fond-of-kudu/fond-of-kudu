<?php

namespace FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Condition;

use Codeception\Test\Unit;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

class ErrorPayoneSettingsIncorrectConditionPluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Condition\ErrorPayoneSettingsIncorrectConditionPlugin|\Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface
     */
    protected ErrorPayoneSettingsIncorrectConditionPlugin|ConditionInterface $plugin;

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

        $this->plugin = new ErrorPayoneSettingsIncorrectConditionPlugin();
    }

    /**
     * @return void
     */
    public function testCheckTrue(): void
    {
        static::assertTrue($this->plugin->check($this->spySalesOrderItemMock));
    }
}
