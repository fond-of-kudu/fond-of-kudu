<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToCurrencyClientInterface;
use Generated\Shared\Transfer\ProductViewTransfer;
use Generated\Shared\Transfer\RestCurrencyTransfer;
use Generated\Shared\Transfer\RestProductPriceAttributesTransfer;

class RestProductPriceAttributeMapper implements RestProductPriceAttributeMapperInterface
{
    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToCurrencyClientInterface
     */
    protected DiscountPromotionsRestApiToCurrencyClientInterface $currencyClient;

    /**
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToCurrencyClientInterface $currencyClient
     */
    public function __construct(DiscountPromotionsRestApiToCurrencyClientInterface $currencyClient)
    {
        $this->currencyClient = $currencyClient;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductPriceAttributesTransfer
     */
    public function mapFromProductViewTransfer(
        ProductViewTransfer $productViewTransfer
    ): RestProductPriceAttributesTransfer {
        $currencyTransfer = $this->currencyClient->getCurrent();

        $restCurrencyTransfer = (new RestCurrencyTransfer())->fromArray(
            $currencyTransfer->toArray(),
            true,
        );

        return (new RestProductPriceAttributesTransfer())
            ->setGrossAmount($productViewTransfer->getPrice())
            ->setPriceTypeName(array_key_first($productViewTransfer->getPrices()))
            ->setCurrency($restCurrencyTransfer);
    }
}
