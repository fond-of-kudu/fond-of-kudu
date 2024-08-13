<?php

namespace FondOfKudu\Zed\Product\Communication\Plugin\Url;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Product\Dependency\Plugin\ProductAbstractPluginUpdateInterface;

/**
 * @method \FondOfKudu\Zed\Product\Business\ProductFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\ProductUrlStore\ProductUrlStoreConfig getConfig()
 * @method \FondOfKudu\Zed\ProductUrlStore\Persistence\ProductUrlStoreQueryContainerInterface getQueryContainer()
 */
class UrlProductAbstractAfterUpdatePlugin extends AbstractPlugin implements ProductAbstractPluginUpdateInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function update(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        return $productAbstractTransfer;
    }
}
