<?php

namespace FondOfKudu\Zed\ProductApiSchedulePriceImport\Business;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\Business\ProductApiSchedulePriceImportBusinessFactory getFactory()
 * @method \FondOfKudu\Zed\ProductApiSchedulePriceImport\Persistence\ProductApiSchedulePriceImportRepositoryInterface getRepository()
 */
class ProductApiSchedulePriceImportFacade extends AbstractFacade implements ProductApiSchedulePriceImportFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function onCreateProductAbstract(
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer {
        return $this->getFactory()
            ->createSalePriceProductAbstractHandler()
            ->handle($productAbstractTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function onUpdateProductAbstract(
        ProductAbstractTransfer $productAbstractTransfer
    ): ProductAbstractTransfer {
        return $this->getFactory()
            ->createSalePriceProductAbstractHandler()
            ->handle($productAbstractTransfer);
    }
}
