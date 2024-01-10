<?php

namespace FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Oms\Condition;

use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

/**
 * @method \FondOfKudu\Zed\OmsPayoneError\OmsPayoneErrorConfig getConfig()
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorRepositoryInterface getRepository()
 * @method \FondOfKudu\Zed\OmsPayoneError\Communication\OmsPayoneErrorCommunicationFactory getFactory()
 */
class ErrorIssueWithCustomerPaymentMethodConditionPlugin extends AbstractPlugin implements ConditionInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem): bool
    {
        return $this->getRepository()->isPaymentPayoneApiLogErrorWithIdSalesOrderAndErrorCodeBetween(
            $orderItem->getFkSalesOrder(),
            [
                'min' => 0,
                'max' => 30,
            ],
        );
    }
}
