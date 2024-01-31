<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client;

use Generated\Shared\Transfer\ProductViewTransfer;

interface DiscountPromotionsRestApiToProductStorageClientInterface
{
    /**
     * Specification:
     * - Retrieves a current Store specific ProductAbstract resource from Storage.
     * - Responds with null if product abstract is restricted.
     * - Maps raw product data to ProductViewTransfer for the current locale.
     * - Based on the super attributes and the selected attributes of the product the result is abstract product.
     * - Executes a stack of `StorageProductExpanderPluginInterface` plugins that expand result.
     * - Filter the restricted product variants (product concrete) in `attribute_map`.
     *
     * @api
     *
     * @param int $idProductAbstract
     * @param string $localeName
     * @param array $selectedAttributes
     *
     * @return \Generated\Shared\Transfer\ProductViewTransfer|null
     */
    public function findProductAbstractViewTransfer(
        int $idProductAbstract,
        string $localeName,
        array $selectedAttributes = []
    ): ?ProductViewTransfer;
}
