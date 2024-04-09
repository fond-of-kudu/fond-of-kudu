<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business;

use Generated\Shared\Transfer\ProductAbstractTransfer;

interface ProductApiSchedulePriceImportFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function onCreateProductAbstract(
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer;

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function onUpdateProductAbstract(
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer;
}
