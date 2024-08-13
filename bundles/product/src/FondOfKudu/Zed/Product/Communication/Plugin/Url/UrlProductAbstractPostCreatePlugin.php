<?php

namespace FondOfKudu\Zed\Product\Communication\Plugin\Url;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductExtension\Dependency\Plugin\ProductAbstractPostCreatePluginInterface;

/**
 * @method \FondOfKudu\Zed\ProductUrlStore\Business\ProductUrlStoreFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\ProductUrlStore\ProductUrlStoreConfig getConfig()
 * @method \FondOfKudu\Zed\ProductUrlStore\Persistence\ProductUrlStoreQueryContainerInterface getQueryContainer()
 */
class UrlProductAbstractPostCreatePlugin extends AbstractPlugin implements ProductAbstractPostCreatePluginInterface
{
    /**
     * Specification:
     * - Executed on "after" event when an abstract product is created.
     * - Can be used to persist additional abstract product related information.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function postCreate(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer {}
}
