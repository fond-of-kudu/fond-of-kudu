<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientBridge;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientBridge;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceBridge;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface;
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
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionRestApiToProductResourceAliasStorageClientInterface
     */
    protected MockObject|DiscountPromotionRestApiToProductResourceAliasStorageClientInterface $productResourceAliasStorageClientMock;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface
     */
    protected MockObject|DiscountPromotionsRestApiToProductStorageClientInterface $productStorageClientMock;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface
     */
    protected MockObject|DiscountPromotionsRestApiToDiscountServiceInterface $discountServiceMock;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\PromotionProductMapperInterface
     */
    protected MockObject|PromotionProductMapperInterface $promotionProductMapperMock;

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

        $this->mapper = new PromotionItemMapper(
            $this->productResourceAliasStorageClientMock,
            $this->productStorageClientMock,
            $this->discountServiceMock,
            $this->promotionProductMapperMock,
        );
    }

    /**
     * @return void
     */
    public function testMapPromotedProductsToRestPromotionalItemsAttributesTransfer(): void
    {
        $locale = 'de_DE';
        $productsData = [];
        $productsData[] = [PromotionItemMapper::ID_PRODUCT_ABSTRACT => 1];

        $this->restPromotionalItemsAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getSkus')
            ->willReturn(['sku-a']);

        $this->productResourceAliasStorageClientMock->expects(static::atLeastOnce())
            ->method('getBulkProductAbstractStorageData')
            ->with(['sku-a'], $locale)
            ->willReturn($productsData);

        $this->productStorageClientMock->expects(static::atLeastOnce())
            ->method('findProductAbstractViewTransfer')
            ->with(1, $locale)
            ->willReturn($this->productViewTransferMock);

        $this->promotionItemTransferMock->expects(static::atLeastOnce())
            ->method('getDiscount')
            ->willReturn($this->discountTransferMock);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getPrice')
            ->willReturn(5999);

        $this->discountServiceMock->expects(static::atLeastOnce())
            ->method('calculate')
            ->with($this->discountCalculationRequestTransferMock)
            ->willReturn($this->discountCalculationResponseTransferMock);

        $this->discountCalculationResponseTransferMock->expects(static::atLeastOnce())
            ->method('getAmount')
            ->willReturn(2000);

        $this->promotionProductMapperMock->expects(static::atLeastOnce())
            ->method('mapProductViewTransferToRestPromotionalProductTransfer')
            ->with($this->productViewTransferMock, $this->discountCalculationResponseTransferMock)
            ->willReturn($this->promotedProductTransferMock);

        $restPromotionalItemsAttributesTransfer = $this->mapper->mapPromotedProductsToRestPromotionalItemsAttributesTransfer(
            $this->restPromotionalItemsAttributesTransferMock,
            $this->promotionItemTransferMock,
            $locale,
        );
    }
}
