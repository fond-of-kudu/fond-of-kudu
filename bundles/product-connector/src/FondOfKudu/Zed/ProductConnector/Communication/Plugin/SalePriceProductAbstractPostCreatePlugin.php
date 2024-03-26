<?php

namespace FondOfKudu\Zed\ProductConnector\Communication\Plugin;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductExtension\Dependency\Plugin\ProductAbstractPostCreatePluginInterface;

/**
 * @method \FondOfKudu\Zed\ProductConnector\Business\ProductConnectorBusinessFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\ProductConnector\ProductConnectorConfig getConfig()
 */
class SalePriceProductAbstractPostCreatePlugin extends AbstractPlugin implements ProductAbstractPostCreatePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function postCreate(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        return $this->getFacade()->persistProductAbstractSalePrice($productAbstractTransfer);
    }
}
