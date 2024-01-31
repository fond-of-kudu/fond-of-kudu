<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi;

use FondOfKudu\Shared\DiscountPromotionsRestApi\DiscountPromotionsRestApiConstants;
use Spryker\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig as SprykerDiscountPromotionsRestApi;

class DiscountPromotionsRestApiConfig extends SprykerDiscountPromotionsRestApi
{
    /**
     * @return string
     */
    public function getImageSetNameForPromotedProductThumb(): string
    {
        return $this->get(
            DiscountPromotionsRestApiConstants::IMAGE_SET_NAME_FOR_PROMOTED_PRODUCT_THUMB,
            'IMG_FRONT',
        );
    }
}
