<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Plugin;

use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\ProductStorageExtension\Dependency\Plugin\ProductViewExpanderPluginInterface;

/**
 * @method \FondOfKudu\Client\ProductImageStorageConnector\ProductImageStorageConnectorFactory getFactory()
 */
class ProductViewImageCustomSetExpanderPlugin extends AbstractPlugin implements ProductViewExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param array<string, mixed> $productData
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ProductViewTransfer
     */
    public function expandProductViewTransfer(
        ProductViewTransfer $productViewTransfer,
        array $productData,
        $localeName
    ): ProductViewTransfer {
        return $this->getFactory()
            ->createProductViewImageCustomSetsExpander()
            ->expandProductViewTransfer($productViewTransfer, $productData, $localeName);
    }
}
