<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use FondOfKudu\Shared\DiscountPromotionsRestApi\DiscountPromotionsRestApiConstants;
use Generated\Shared\Transfer\ProductImageSetTransfer;
use Generated\Shared\Transfer\ProductImageStorageTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use Generated\Shared\Transfer\RestProductPriceAttributesTransfer;
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestProductPriceAttributeMapper
     */
    protected MockObject|RestProductPriceAttributeMapper $restProductPriceAttributeMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestProductPriceAttributesTransfer
     */
    protected MockObject|RestProductPriceAttributesTransfer $restProductPriceAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductImageStorageTransfer
     */
    protected MockObject|ProductImageStorageTransfer $productImageSetStorageTransferMock;

    protected MockObject|RestResponseProductImageMapperInterface $restResponseProductImageMapperMock;

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

        $this->restProductPriceAttributeMapperMock = $this->getMockBuilder(RestProductPriceAttributeMapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductPriceAttributesTransferMock = $this->getMockBuilder(RestProductPriceAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productImageSetStorageTransferMock = $this->getMockBuilder(ProductImageSetTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseProductImageMapperMock = $this->getMockBuilder(RestResponseProductImageMapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapper = new PromotionProductMapper(
            $this->discountPromotionsRestApiConfigMock,
            $this->restProductPriceAttributeMapperMock,
            $this->restResponseProductImageMapperMock,
        );
    }

    /**
     * @return void
     */
    public function testMapProductViewTransferToRestPromotionalProductTransfer(): void
    {
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
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_URL_KEY,
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
                DiscountPromotionsRestApiConstants::PRODUCT_ATTR_URL_KEY => DiscountPromotionsRestApiConstants::PRODUCT_ATTR_URL_KEY,
            ]);

        $this->restProductPriceAttributeMapperMock->expects(static::atLeastOnce())
            ->method('mapFromProductViewTransfer')
            ->with($this->productViewTransferMock)
            ->willReturn($this->restProductPriceAttributesTransferMock);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([
                'name' => 'product name',
                'sku' => 'sku-a',
                'price' => 5999,
                'prices' => ['DEFAULT' => 5999],
                'available' => true,
            ]);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn('sku-a');

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getAvailable')
            ->willReturn(true);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getPrice')
            ->willReturn(5999);

        $this->restResponseProductImageMapperMock->expects(static::atLeastOnce())
            ->method('mapFromProductViewTransfer')
            ->with($this->productViewTransferMock)
            ->willReturn([
                [
                    'name' => 'Thumbnail',
                    'images' => [
                        [
                            'id_product_image' => 7963228,
                            'external_url_large' => 'https://fondof.getbynder.com/images/media/5D83D85F-FC78-49AF-874B2C5E88AE38AA?w=768&h=768',
                            'external_url_small' => 'https://fondof.getbynder.com/images/media/5D83D85F-FC78-49AF-874B2C5E88AE38AA?w=384&h=384',
                            'image_sets' => [
                            ],
                        ],
                    ],
                ],
            ]);

        $promotedProductTransfer = $this->mapper->mapProductViewTransferToRestPromotionalProductTransfer(
            $this->productViewTransferMock,
            2000,
            'uuid',
        );

        static::assertEquals($promotedProductTransfer->getName(), 'product name');
        static::assertEquals($promotedProductTransfer->getSku(), 'sku-a');
        static::assertEquals($promotedProductTransfer->getAbstractSku(), 'Abstract-sku-a');
        static::assertEquals($promotedProductTransfer->getPrice(), 5999);
        static::assertCount(1, $promotedProductTransfer->getPrices());
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
        static::assertEquals($promotedProductTransfer->getAttributes()[DiscountPromotionsRestApiConstants::PRODUCT_ATTR_URL_KEY], DiscountPromotionsRestApiConstants::PRODUCT_ATTR_URL_KEY);
    }

    /**
     * @return void
     */
    public function testMapProductViewTransferToRestPromotionalProductTransferNotAvailable(): void
    {
        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getAvailable')
            ->willReturn(false);

        $this->productViewTransferMock->expects(static::never())
            ->method('getPrice');

        static::assertNull($this->mapper->mapProductViewTransferToRestPromotionalProductTransfer(
            $this->productViewTransferMock,
            2000,
            'uuid',
        ));
    }
}
