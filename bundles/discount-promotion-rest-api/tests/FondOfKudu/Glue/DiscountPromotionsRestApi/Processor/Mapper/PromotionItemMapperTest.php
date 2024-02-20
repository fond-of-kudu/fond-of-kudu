<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientBridge;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientBridge;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceBridge;
use Generated\Shared\Transfer\DiscountCalculationRequestTransfer;
use Generated\Shared\Transfer\DiscountCalculationResponseTransfer;
use Generated\Shared\Transfer\DiscountTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use Generated\Shared\Transfer\PromotedProductTransfer;
use Generated\Shared\Transfer\PromotionItemTransfer;
use Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PromotionItemMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientBridge
     */
    protected MockObject|DiscountPromotionRestApiToProductResourceAliasStorageClientBridge $productResourceAliasStorageClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientBridge
     */
    protected MockObject|DiscountPromotionsRestApiToProductStorageClientBridge $productStorageClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceBridge
     */
    protected MockObject|DiscountPromotionsRestApiToDiscountServiceBridge $discountServiceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionProductMapper
     */
    protected MockObject|PromotionProductMapper $promotionProductMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestPromotionalItemsAttributesTransfer
     */
    protected MockObject|RestPromotionalItemsAttributesTransfer $restPromotionalItemsAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PromotionItemTransfer
     */
    protected MockObject|PromotionItemTransfer $promotionItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductViewTransfer
     */
    protected MockObject|ProductViewTransfer $productViewTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\DiscountTransfer
     */
    protected MockObject|DiscountTransfer $discountTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\DiscountCalculationRequestTransfer
     */
    protected MockObject|DiscountCalculationRequestTransfer $discountCalculationRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\DiscountCalculationResponseTransfer
     */
    protected MockObject|DiscountCalculationResponseTransfer $discountCalculationResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PromotedProductTransfer
     */
    protected MockObject|PromotedProductTransfer $promotedProductTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\DiscountCalculationRequestMapper
     */
    protected MockObject|DiscountCalculationRequestMapper $discountCalculationRequestMapperMock;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionItemMapper
     */
    protected PromotionItemMapper $mapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productResourceAliasStorageClientMock = $this->getMockBuilder(DiscountPromotionRestApiToProductResourceAliasStorageClientBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productStorageClientMock = $this->getMockBuilder(DiscountPromotionsRestApiToProductStorageClientBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->discountServiceMock = $this->getMockBuilder(DiscountPromotionsRestApiToDiscountServiceBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->promotionProductMapperMock = $this->getMockBuilder(PromotionProductMapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restPromotionalItemsAttributesTransferMock = $this->getMockBuilder(RestPromotionalItemsAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->promotionItemTransferMock = $this->getMockBuilder(PromotionItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productViewTransferMock = $this->getMockBuilder(ProductViewTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->discountTransferMock = $this->getMockBuilder(DiscountTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->discountCalculationRequestTransferMock = $this->getMockBuilder(DiscountCalculationRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->discountCalculationResponseTransferMock = $this->getMockBuilder(DiscountCalculationResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->promotedProductTransferMock = $this->getMockBuilder(PromotedProductTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->discountCalculationRequestMapperMock = $this->getMockBuilder(DiscountCalculationRequestMapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mapper = new PromotionItemMapper(
            $this->productResourceAliasStorageClientMock,
            $this->productStorageClientMock,
            $this->discountServiceMock,
            $this->promotionProductMapperMock,
            $this->discountCalculationRequestMapperMock,
        );
    }

    /**
     * @return void
     */
    public function testMapPromotedProductsToRestPromotionalItemsAttributesTransfer()
    {
        $locale = 'en_US';
        $skus = ['sku-a'];

        $this->restPromotionalItemsAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getSkus')
            ->willReturn($skus);

        $this->productResourceAliasStorageClientMock->expects(static::atLeastOnce())
            ->method('getBulkProductAbstractStorageData')
            ->with($skus, $locale)
            ->willReturn([[PromotionItemMapper::ID_PRODUCT_ABSTRACT => 1]]);

        $this->productStorageClientMock->expects(static::atLeastOnce())
            ->method('findProductAbstractViewTransfer')
            ->with(1, $locale)
            ->willReturn($this->productViewTransferMock);

        $this->promotionItemTransferMock->expects(static::atLeastOnce())
            ->method('getDiscount')
            ->willReturn($this->discountTransferMock);

        $this->promotionItemTransferMock->expects(static::atLeastOnce())
            ->method('getUuid')
            ->willReturn('uuid');

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getPrice')
            ->willReturn(5999);

        $this->discountCalculationRequestMapperMock->expects(static::atLeastOnce())
            ->method('mapFromDiscountTransfer')
            ->with($this->discountTransferMock, 5999)
            ->willReturn($this->discountCalculationRequestTransferMock);

        $this->discountServiceMock->expects(static::atLeastOnce())
            ->method('calculate')
            ->with($this->discountCalculationRequestTransferMock)
            ->willReturn($this->discountCalculationResponseTransferMock);

        $this->discountCalculationResponseTransferMock->expects(static::atLeastOnce())
            ->method('getAmount')
            ->willReturn(2000);

        $result = $this->mapper->mapPromotedProductsToRestPromotionalItemsAttributesTransfer(
            $this->restPromotionalItemsAttributesTransferMock,
            $this->promotionItemTransferMock,
            $locale,
        );

        static::assertEquals($result, $this->restPromotionalItemsAttributesTransferMock);
    }
}
