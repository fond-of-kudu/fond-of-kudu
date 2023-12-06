<?php

namespace FondOfKudu\Zed\OmsRetryCaptureProcess\Communication\Plugin\Condition;

use DateTime;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Propel\Runtime\Exception\PropelException;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

/**
 * @method \FondOfKudu\Zed\OmsRetryCaptureProcess\OmsRetryCaptureProcessConfig getConfig()
 */
class CaptureCircuitBreakerConditionPlugin extends AbstractPlugin implements ConditionInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem): bool
    {
        try {
            $createdAt = $orderItem->getOrder()->getCreatedAt();
            $interval = $createdAt->diff(new DateTime());
        } catch (PropelException $e) {
            return false;
        }

        return $interval->h > $this->getConfig()->getHoursAfterCaptureFinalFailed();
    }
}
