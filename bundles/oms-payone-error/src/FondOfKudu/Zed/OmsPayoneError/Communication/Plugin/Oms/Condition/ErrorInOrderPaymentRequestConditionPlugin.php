<?php

namespace FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Oms\Condition;

use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

/**
 * @method \FondOfKudu\Zed\OmsPayoneError\OmsPayoneErrorConfig getConfig()
 * @method \FondOfKudu\Zed\OmsPayoneError\Business\OmsPayoneErrorFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorQueryContainerInterface getQueryContainer()
 * @method \FondOfKudu\Zed\OmsPayoneError\Communication\OmsPayoneErrorCommunicationFactory getFactory()
 */
class ErrorInOrderPaymentRequestConditionPlugin extends AbstractPlugin implements ConditionInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem): bool
    {
        return true;
    }
}
