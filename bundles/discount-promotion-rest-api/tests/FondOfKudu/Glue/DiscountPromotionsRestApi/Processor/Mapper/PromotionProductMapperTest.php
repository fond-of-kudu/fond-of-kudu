<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use FondOfKudu\Shared\DiscountPromotionsRestApi\DiscountPromotionsRestApiConstants;
use Generated\Shared\Transfer\ProductImageStorageTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PromotionProductMapperTest extends Unit
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
        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getPrice')
            ->willReturn(5999);

        $this->discountPromotionsRestApiConfigMock->expects(static::atLeastOnce())
            ->method('getProductViewTransferAttributesToMap')
            ->willReturn([
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
            ]);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getAttributes')
            ->willReturn([
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_STYLE => DiscountPromotionsRestApiConstants::PRODUCT_ATTR_STYLE,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_MODEL => DiscountPromotionsRestApiConstants::PRODUCT_ATTR_MODEL,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_MODEL_KEY => DiscountPromotionsRestApiConstants::PRODUCT_ATTR_MODEL_KEY,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_FROM => DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_FROM,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_TO => DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_TO,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE => DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_FEATURE_HIGHLIGHT => DiscountPromotionsRestApiConstants::PRODUCT_ATTR_FEATURE_HIGHLIGHT,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_FEATURE_EDITION => DiscountPromotionsRestApiConstants::PRODUCT_ATTR_FEATURE_EDITION,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_RESTOCK_DATE => DiscountPromotionsRestApiConstants::PRODUCT_ATTR_RESTOCK_DATE,
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_RELEASE_DATE => DiscountPromotionsRestApiConstants::PRODUCT_ATTR_RELEASE_DATE,
            ]);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([
                'name' => 'product name',
                'sku' => 'sku-a',
                //'abstractSku' => 'Abstract-sku-a',
                'price' => 5999,
                'prices' => ['DEFAULT' => 5999],
                'available' => true,
            ]);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn('sku-a');

        $productImageStorageTransferMock = $this->getMockBuilder(ProductImageStorageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getImageSets')
            ->willReturn(['ADDITIONALIMAGE' => new ArrayObject([$productImageStorageTransferMock])]);

        $this->discountPromotionsRestApiConfigMock->expects(static::atLeastOnce())
            ->method('getImageSetByName')
            ->willReturn(null);

        $promotedProductTransfer = $this->mapper->mapProductViewTransferToRestPromotionalProductTransfer(
            $this->productViewTransferMock,
            2000,
            'uuid',
        );

        static::assertEquals($promotedProductTransfer->getName(), 'product name');
        static::assertEquals($promotedProductTransfer->getSku(), 'sku-a');
        static::assertEquals($promotedProductTransfer->getAbstractSku(), 'Abstract-sku-a');
        static::assertEquals($promotedProductTransfer->getPrice(), 5999);
        static::assertArrayHasKey('DEFAULT', $promotedProductTransfer->getPrices());
        static::assertTrue($promotedProductTransfer->getAvailable());
        static::assertArrayHasKey(DiscountPromotionsRestApiConstants::PRODUCT_ATTR_STYLE, $promotedProductTransfer->getAttributes());
        static::assertArrayHasKey(DiscountPromotionsRestApiConstants::PRODUCT_ATTR_MODEL, $promotedProductTransfer->getAttributes());
        static::assertArrayHasKey(DiscountPromotionsRestApiConstants::PRODUCT_ATTR_MODEL_KEY, $promotedProductTransfer->getAttributes());
        static::assertArrayHasKey(DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_FROM, $promotedProductTransfer->getAttributes());
        static::assertArrayHasKey(DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_TO, $promotedProductTransfer->getAttributes());
        static::assertArrayHasKey(DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE, $promotedProductTransfer->getAttributes());
        static::assertArrayHasKey(DiscountPromotionsRestApiConstants::PRODUCT_ATTR_FEATURE_HIGHLIGHT, $promotedProductTransfer->getAttributes());
        static::assertArrayHasKey(DiscountPromotionsRestApiConstants::PRODUCT_ATTR_FEATURE_EDITION, $promotedProductTransfer->getAttributes());
        static::assertArrayHasKey(DiscountPromotionsRestApiConstants::PRODUCT_ATTR_RESTOCK_DATE, $promotedProductTransfer->getAttributes());
        static::assertArrayHasKey(DiscountPromotionsRestApiConstants::PRODUCT_ATTR_RELEASE_DATE, $promotedProductTransfer->getAttributes());
        static::assertEquals($promotedProductTransfer->getAttributes()[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_STYLE], DiscountPromotionsRestApiConstants::PRODUCT_ATTR_STYLE);
        static::assertEquals($promotedProductTransfer->getAttributes()[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_MODEL], DiscountPromotionsRestApiConstants::PRODUCT_ATTR_MODEL);
        static::assertEquals($promotedProductTransfer->getAttributes()[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_MODEL_KEY], DiscountPromotionsRestApiConstants::PRODUCT_ATTR_MODEL_KEY);
        static::assertEquals($promotedProductTransfer->getAttributes()[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_FROM], DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_FROM);
        static::assertEquals($promotedProductTransfer->getAttributes()[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_TO], DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE_TO);
        static::assertEquals($promotedProductTransfer->getAttributes()[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_SPECIAL_PRICE], 3999);
        static::assertEquals($promotedProductTransfer->getAttributes()[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_FEATURE_HIGHLIGHT], DiscountPromotionsRestApiConstants::PRODUCT_ATTR_FEATURE_HIGHLIGHT);
        static::assertEquals($promotedProductTransfer->getAttributes()[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_FEATURE_EDITION], DiscountPromotionsRestApiConstants::PRODUCT_ATTR_FEATURE_EDITION);
        static::assertEquals($promotedProductTransfer->getAttributes()[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_RESTOCK_DATE], DiscountPromotionsRestApiConstants::PRODUCT_ATTR_RESTOCK_DATE);
        static::assertEquals($promotedProductTransfer->getAttributes()[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_RELEASE_DATE], DiscountPromotionsRestApiConstants::PRODUCT_ATTR_RELEASE_DATE);
        static::assertArrayHasKey('ADDITIONALIMAGE', $promotedProductTransfer->getImages());
    }
}
