<?php

namespace FondOfKudu\Zed\ProductConnector\Business;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\ProductConnector\Business\ProductConnectorBusinessFactory getFactory()
 */
class ProductConnectorBusinessFacade extends AbstractFacade implements ProductConnectorBusinessFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function persistProductAbstractSalePrice(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        return $productAbstractTransfer;
    }
}
