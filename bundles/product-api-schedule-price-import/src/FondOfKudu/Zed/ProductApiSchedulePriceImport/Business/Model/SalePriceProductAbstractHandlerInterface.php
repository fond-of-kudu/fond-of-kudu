<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface SalePriceProductAbstractHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function handle(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer;
}
