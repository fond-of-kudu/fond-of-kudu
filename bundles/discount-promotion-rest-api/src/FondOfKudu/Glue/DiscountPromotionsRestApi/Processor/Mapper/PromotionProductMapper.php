<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use ArrayObject;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductImageStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use FondOfKudu\Shared\DiscountPromotionsRestApi\DiscountPromotionsRestApiConstants;
use Generated\Shared\Transfer\ProductViewTransfer;
use Generated\Shared\Transfer\PromotedProductTransfer;

class PromotionProductMapper implements PromotionProductMapperInterface
{
    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig
     */
    protected DiscountPromotionsRestApiConfig $config;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestProductPriceAttributeMapperInterface
     */
    protected RestProductPriceAttributeMapperInterface $restProductPriceAttributeMapper;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductImageStorageClientInterface
     */
    protected DiscountPromotionsRestApiToProductImageStorageClientInterface $productImageStorageClient;

    /**
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig $config
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestProductPriceAttributeMapperInterface $restProductPriceAttributeMapper
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductImageStorageClientInterface $productImageStorageClient
     */
    public function __construct(
        DiscountPromotionsRestApiConfig $config,
        RestProductPriceAttributeMapperInterface $restProductPriceAttributeMapper,
        DiscountPromotionsRestApiToProductImageStorageClientInterface $productImageStorageClient
    ) {
        $this->config = $config;
        $this->restProductPriceAttributeMapper = $restProductPriceAttributeMapper;
        $this->productImageStorageClient = $productImageStorageClient;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param int $discountAmount
     * @param string $discountPromotionUuid
     * @param string $locale
     *
     * @return \Generated\Shared\Transfer\PromotedProductTransfer
     */
    public function mapProductViewTransferToRestPromotionalProductTransfer(
        ProductViewTransfer $productViewTransfer,
        int $discountAmount,
        string $discountPromotionUuid,
        string $locale
    ): PromotedProductTransfer {
        $specialPrice = $productViewTransfer->getPrice() - $discountAmount;
        $attributes = $this->mapAttributesFromProductViewTransfer($productViewTransfer);
        $attributes[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE] = $specialPrice;
        $prices = new ArrayObject([
            $this->restProductPriceAttributeMapper->mapFromProductViewTransfer($productViewTransfer),
        ]);

        return (new PromotedProductTransfer())
            ->fromArray($productViewTransfer->toArray(), true)
            ->setAbstractSku('Abstract-' . $productViewTransfer->getSku())
            ->setDiscountPromotionUuid($discountPromotionUuid)
            ->setImages($this->mapImagesFromStorage($productViewTransfer, $locale))
            ->setPrices($prices)
            ->setAttributes($attributes);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return array
     */
    protected function mapAttributesFromProductViewTransfer(
        ProductViewTransfer $productViewTransfer
    ): array {
        $attributes = [];

        foreach ($this->config->getProductViewTransferAttributesToMap() as $attributeName) {
            if (array_key_exists($attributeName, $productViewTransfer->getAttributes())) {
                $attributes[$attributeName] = $productViewTransfer->getAttributes()[$attributeName];
            }
        }

        return $attributes;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param string $locale
     *
     * @return array<array>
     */
    protected function mapImagesFromStorage(
        ProductViewTransfer $productViewTransfer,
        string $locale
    ): array {
        $images = [];
        $productImageSetStorageTransferCollection = $this->productImageStorageClient->resolveProductImageSetStorageTransfers(
            $productViewTransfer->getIdProductAbstract(),
            $productViewTransfer->getIdProductConcrete(),
            $locale,
        );

        /** @var \Generated\Shared\Transfer\ProductImageSetStorageTransfer $productImageSetStorageTransfer */
        foreach ($productImageSetStorageTransferCollection as $productImageSetStorageTransfer) {
            if ($this->config->getImageSetByName() === false) {
                $images[] = $productImageSetStorageTransfer->toArray();

                continue;
            }

            if ($this->config->getImageSetByName() === $productImageSetStorageTransfer->getName()) {
                return [[$productImageSetStorageTransfer->toArray()]];
            }
        }

        return $images;
    }
}
