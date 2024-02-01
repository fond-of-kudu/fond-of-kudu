<?php

namespace FondOfKudu\Zed\OmsPayoneError\Communication\Plugin\Oms\Condition;

use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

/**
 * @method \FondOfKudu\Zed\OmsPayoneError\Persistence\OmsPayoneErrorRepositoryInterface getRepository()
 */
class Error3dSecureConditionPlugin extends AbstractPlugin implements ConditionInterface
{
    /**
     * @var int
     */
    public const ERROR_MIN = 4200;

    /**
     * @var int
     */
    public const ERROR_MAX = 4299;

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem): bool
    {
        $errorCode = $this->getRepository()->findPaymentPayoneApiLogErrorWithIdSalesOrder($orderItem->getFkSalesOrder());

        return $errorCode !== null && (int)$errorCode >= static::ERROR_MIN && (int)$errorCode <= static::ERROR_MAX;
    }
}
