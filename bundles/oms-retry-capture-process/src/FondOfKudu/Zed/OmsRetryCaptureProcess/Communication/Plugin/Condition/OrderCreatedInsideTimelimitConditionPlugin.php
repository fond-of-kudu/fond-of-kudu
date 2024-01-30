<?php

namespace FondOfKudu\Zed\OmsRetryCaptureProcess\Communication\Plugin\Condition;

use DateTime;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Propel\Runtime\Exception\PropelException;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

/**
 * @method \FondOfKudu\Zed\OmsRetryCaptureProcess\OmsRetryCaptureProcessConfig getConfig()
 * @method \FondOfKudu\Zed\OmsRetryCaptureProcess\Communication\OmsRetryCaptureProcessCommunicationFactory getFactory()
 */
class OrderCreatedInsideTimelimitConditionPlugin extends AbstractPlugin implements ConditionInterface
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
            $diff = round(((new DateTime())->getTimestamp() - $createdAt->getTimestamp()) / 3600);
        } catch (PropelException $e) {
            return false;
        }

        return $this->getConfig()->getHoursAfterCaptureFinalFailed() > $diff;
    }
}
