<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi;

use FondOfKudu\Shared\DiscountPromotionsRestApi\DiscountPromotionsRestApiConstants;
use Spryker\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig as SprykerDiscountPromotionsRestApi;

class DiscountPromotionsRestApiConfig extends SprykerDiscountPromotionsRestApi
{
    /**
     * @return array<string>
     */
    public function getProductViewTransferAttributesToMap(): array
    {
        return $this->get(
            DiscountPromotionsRestApiConstants::PRODUCT_VIEW_TRANSFER_ATTRIBUTES_TO_MAP,
            [
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_STYLE,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_MODEL,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_MODEL_KEY,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_FROM,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_TO,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_FEATURE_HIGHLIGHT,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_FEATURE_EDITION,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_RESTOCK_DATE,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_RELEASE_DATE,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_URL_KEY,
            ],
        );
    }

    /**
     * @return string|null
     */
    public function getImageSetByName(): ?string
    {
        return $this->get(DiscountPromotionsRestApiConstants::IMAGE_SET_NAME);
    }
}
