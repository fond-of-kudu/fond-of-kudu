<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\Model;

use Generated\Shared\Transfer\ProductConcreteTransfer;

interface SalePriceProductConcreteHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param array $attributes
     *
     * @return void
     */
    public function handle(
        ProductConcreteTransfer $productConcreteTransfer,
        array $attributes = []
    ): void;
}
