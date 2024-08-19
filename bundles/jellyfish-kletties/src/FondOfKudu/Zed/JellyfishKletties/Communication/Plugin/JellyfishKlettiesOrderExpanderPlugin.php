<?php

namespace FondOfKudu\Zed\JellyfishKletties\Communication\Plugin;

use FondOfOryx\Zed\JellyfishSalesOrderExtension\Dependency\Plugin\JellyfishOrderExpanderPostMapPluginInterface;
use Generated\Shared\Transfer\JellyfishOrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * Class JellyfishKlettiesOrderExpanderPlugin
 *
 * @package FondOfKudu\Zed\JellyfishKletties\Dependency\Plugin
 *
 * @method \FondOfKudu\Zed\JellyfishKletties\Communication\JellyfishKlettiesCommunicationFactory getFactory()
 * @method \FondOfKudu\Zed\JellyfishKletties\JellyfishKlettiesConfig getConfig()
 * @method \FondOfKudu\Zed\JellyfishKletties\Business\JellyfishKlettiesFacadeInterface getFacade()
 */
class JellyfishKlettiesOrderExpanderPlugin extends AbstractPlugin implements JellyfishOrderExpanderPostMapPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\JellyfishOrderTransfer $jellyfishOrderTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrder
     *
     * @return \Generated\Shared\Transfer\JellyfishOrderTransfer
     */
    public function expand(
        JellyfishOrderTransfer $jellyfishOrderTransfer,
        SpySalesOrder $salesOrder
    ): JellyfishOrderTransfer {
        $klettiesOrder = $salesOrder->getFokKlettiesOrder();

        if ($klettiesOrder !== null) {
            $klettiesOrderTransfer = $this->getFactory()->getKlettiesFacade()->convertKlettiesOrderEntityToTransfer($klettiesOrder);
            $jellyfishOrderTransfer->setKlettiesOrder($klettiesOrderTransfer);
        }

        return $jellyfishOrderTransfer;
    }
}
