<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Expander;

use Generated\Shared\Transfer\ProductViewTransfer;

interface ProductViewImageCustomSetsExpanderInterface
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
        string $localeName
    ): ProductViewTransfer;
}
