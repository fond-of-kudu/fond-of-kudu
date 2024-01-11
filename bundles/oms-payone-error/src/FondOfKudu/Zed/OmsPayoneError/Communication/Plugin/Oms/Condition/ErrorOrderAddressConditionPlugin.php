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
class ErrorOrderAddressConditionPlugin extends AbstractPlugin implements ConditionInterface
{
    /**
     * @var int
     */
    public const ERROR_MIN = 4000;

    /**
     * @var int
     */
    public const ERROR_MAX = 4099;

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem): bool
    {
        $errorCode = (int)$this->getRepository()->findPaymentPayoneApiLogErrorWithIdSalesOrder($orderItem->getFkSalesOrder());

        return $errorCode >= static::ERROR_MIN && $errorCode <= static::ERROR_MAX;
    }
}
