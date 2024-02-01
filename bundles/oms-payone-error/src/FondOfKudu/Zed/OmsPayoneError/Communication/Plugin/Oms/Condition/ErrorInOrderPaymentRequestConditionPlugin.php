<?php

namespace FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Oms\Condition;

use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

/**
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorRepositoryInterface getRepository()
 */
class ErrorInOrderPaymentRequestConditionPlugin extends AbstractPlugin implements ConditionInterface
{
    /**
     * @var int
     */
    public const ERROR_MIN = 1000;

    /**
     * @var int
     */
    public const ERROR_MAX = 1099;

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem): bool
    {
        $errorCode = $this->getRepository()->findPaymentPayoneApiLogErrorWithIdSalesOrder($orderItem->getFkSalesOrder());

        if ($errorCode === null) {
            return false;
        }

        return (int)$errorCode >= static::ERROR_MIN && (int)$errorCode <= static::ERROR_MAX;
    }
}
