<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use Generated\Shared\Transfer\ProductImageStorageTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PromotionProductMapperText extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig
     */
    protected MockObject|DiscountPromotionsRestApiConfig $discountPromotionsRestApiConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductViewTransfer
     */
    protected MockObject|ProductViewTransfer $productViewTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductImageStorageTransfer
     */
    protected MockObject|ProductImageStorageTransfer $productImageStorageTransferMock;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionProductMapperInterface
     */
    protected PromotionProductMapperInterface $mapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->discountPromotionsRestApiConfigMock = $this->getMockBuilder(DiscountPromotionsRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productViewTransferMock = $this->getMockBuilder(ProductViewTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productImageStorageTransferMock = $this->getMockBuilder(ProductImageStorageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapper = new PromotionProductMapper($this->discountPromotionsRestApiConfigMock);
    }

    /**
     * @return void
     */
    public function testMapProductViewTransferToRestPromotionalProductTransfer(): void
    {
        $productViewTransferAttributes = [
            PromotionProductMapper::PRODUCT_ATTR_BRAND => 'brand',
            PromotionProductMapper::PRODUCT_ATTR_MODEL => 'model',
            PromotionProductMapper::PRODUCT_ATTR_MODEL_KEY => 'modelKey',
            PromotionProductMapper::PRODUCT_ATTR_MODEL_SIZE => 'modelSize',
            PromotionProductMapper::PRODUCT_ATTR_STYLE => 'style',
            PromotionProductMapper::PRODUCT_ATTR_STYLE_KEY => 'styleKey',
            PromotionProductMapper::PRODUCT_ATTR_TYPE => 'type',
        ];

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([
                'name' => 'product name',
                'sku' => 'sku-a',
                'price' => 5999,
            ]);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn($productViewTransferAttributes);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getImages')
            ->willReturn([
                [
                    'IMG_FRONT' => [$this->productImageStorageTransferMock],
                ],
            ]);

        $this->discountPromotionsRestApiConfigMock->expects(static::atLeastOnce())
            ->method('getImageSetNameForPromotedProductThumb')
            ->willReturn('IMG_FRONT');

        $promotedProductTransfer = $this->mapper->mapProductViewTransferToRestPromotionalProductTransfer(
            $this->productViewTransferMock,
            2000,
        );

        static::assertEquals($promotedProductTransfer->getBrand(), $productViewTransferAttributes[PromotionProductMapper::PRODUCT_ATTR_BRAND]);
        static::assertEquals($promotedProductTransfer->getModel(), $productViewTransferAttributes[PromotionProductMapper::PRODUCT_ATTR_MODEL]);
        static::assertEquals($promotedProductTransfer->getModelKey(), $productViewTransferAttributes[PromotionProductMapper::PRODUCT_ATTR_MODEL_KEY]);
        static::assertEquals($promotedProductTransfer->getModelSize(), $productViewTransferAttributes[PromotionProductMapper::PRODUCT_ATTR_MODEL_SIZE]);
        static::assertEquals($promotedProductTransfer->getStyle(), $productViewTransferAttributes[PromotionProductMapper::PRODUCT_ATTR_STYLE]);
        static::assertEquals($promotedProductTransfer->getStyleKey(), $productViewTransferAttributes[PromotionProductMapper::PRODUCT_ATTR_STYLE_KEY]);
        static::assertEquals($promotedProductTransfer->getType(), $productViewTransferAttributes[PromotionProductMapper::PRODUCT_ATTR_TYPE]);
        static::assertNotNull($promotedProductTransfer->getThumb());
    }
}
