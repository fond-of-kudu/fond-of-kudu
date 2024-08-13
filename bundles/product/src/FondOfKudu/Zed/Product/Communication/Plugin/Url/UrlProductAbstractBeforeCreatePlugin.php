<?php

namespace FondOfKudu\Zed\Product\Communication\Plugin\Url;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductExtension\Dependency\Plugin\ProductAbstractPreCreatePluginInterface;

class UrlProductAbstractBeforeCreatePlugin extends AbstractPlugin implements ProductAbstractPreCreatePluginInterface
{
    /**
     * Specification:
     * - Executed before an abstract product is created.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function preCreate(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        return $productAbstractTransfer;
    }
}
