<?php

namespace FondOfKudu\Zed\ProductConnector\Business;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductConnectorBusinessFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function persistProductAbstractSalePrice(
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer;
}
