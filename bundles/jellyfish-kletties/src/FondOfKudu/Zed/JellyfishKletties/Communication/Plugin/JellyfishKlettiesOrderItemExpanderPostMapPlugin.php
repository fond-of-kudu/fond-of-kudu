<?php

namespace FondOfKudu\Zed\JellyfishKletties\Communication\Plugin;

use FondOfKudu\Zed\JellyfishSalesOrderExtension\Dependency\Plugin\JellyfishOrderItemExpanderPostMapPluginInterface;
use Generated\Shared\Transfer\JellyfishOrderItemTransfer;
use Generated\Shared\Transfer\JellyfishKlettiesVendorTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;

class JellyfishKlettiesOrderItemExpanderPostMapPlugin implements JellyfishOrderItemExpanderPostMapPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\JellyfishOrderItemTransfer $jellyfishOrderItemTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $salesOrderItem
     *
     * @return \Generated\Shared\Transfer\JellyfishOrderItemTransfer
     */
    public function expand(
        JellyfishOrderItemTransfer $jellyfishOrderItemTransfer,
        SpySalesOrderItem $salesOrderItem
    ): JellyfishOrderItemTransfer {
        if ($salesOrderItem->getVendorSku() === null) {
            return $jellyfishOrderItemTransfer;
        }

        $vendor = (new JellyfishKlettiesVendorTransfer())
            ->setName($salesOrderItem->getVendor())
            ->setSku($salesOrderItem->getVendorSku());

        return $jellyfishOrderItemTransfer
            ->setVendor($vendor);
    }
}
