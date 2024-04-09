<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use Generated\Shared\Transfer\ProductConcreteTransfer;

interface SalePriceProductConcreteHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function handle(ProductConcreteTransfer $productConcreteTransfer): ProductConcreteTransfer;
}
