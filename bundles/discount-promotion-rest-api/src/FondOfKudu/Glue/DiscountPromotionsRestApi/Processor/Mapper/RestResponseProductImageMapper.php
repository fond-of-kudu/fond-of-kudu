<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use Generated\Shared\Transfer\ProductImageStorageTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;

class RestResponseProductImageMapper implements RestResponseProductImageMapperInterface
{
    /**
     * @var string
     */
    public const IMAGE_SET_NAME = 'name';

    /**
     * @var string
     */
    public const IMAGE_COLLECTION = 'images';

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig
     */
    protected DiscountPromotionsRestApiConfig $config;

    /**
     * @param \FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig $config
     */
    public function __construct(DiscountPromotionsRestApiConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return array<array>
     */
    public function mapFromProductViewTransfer(ProductViewTransfer $productViewTransfer): array
    {
        $images = [];

        /** @var array<\Generated\Shared\Transfer\ProductImageStorageTransfer> $productImageStorageTransferCollection */
        foreach ($productViewTransfer->getImageSets() as $index => $productImageStorageTransferCollection) {
            foreach ($productImageStorageTransferCollection as $productImageStorageTransfer) {
                if (!$productImageStorageTransfer instanceof ProductImageStorageTransfer) {
                    continue;
                }

                if ($this->config->getImageSetByName() === false) {
                    $images[] = $this->buildArray($index, $productImageStorageTransfer);

                    continue;
                }

                if ($this->config->getImageSetByName() === $index) {
                    return [$this->buildArray($index, $productImageStorageTransfer)];
                }
            }
        }

        return $images;
    }

    /**
     * @param string $name
     * @param \Generated\Shared\Transfer\ProductImageSetStorageTransfer $productImageStorageTransfer
     *
     * @return array
     */
    protected function buildArray(string $name, ProductImageStorageTransfer $productImageStorageTransfer): array
    {
        return [
            static::IMAGE_SET_NAME => $name,
            static::IMAGE_COLLECTION => $productImageStorageTransfer->toArray(),
        ];
    }
}
