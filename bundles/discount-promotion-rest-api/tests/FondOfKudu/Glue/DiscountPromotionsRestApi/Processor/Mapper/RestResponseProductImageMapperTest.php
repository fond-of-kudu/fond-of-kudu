<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use FondOfKudu\Glue\DiscountPromotionsRestApi\DiscountPromotionsRestApiConfig;
use Generated\Shared\Transfer\ProductImageStorageTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestResponseProductImageMapperTest extends Unit
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
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestResponseProductImageMapperInterface
     */
    protected RestResponseProductImageMapperInterface $restResponseProductImageMapper;

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

        $this->restResponseProductImageMapper = new RestResponseProductImageMapper(
            $this->discountPromotionsRestApiConfigMock,
        );
    }

    /**
     * @return void
     */
    public function testMapFromProductViewTransfer(): void
    {
        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getImageSets')
            ->willReturn(['THUMBNAIL' => [$this->productImageStorageTransferMock]]);

        $this->productImageStorageTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([
                    [
                        'name' => 'Thumbnail',
                        'images' => [
                            [
                                'id_product_image' => 7963228,
                                'external_url_large' => 'https://fondof.getbynder.com/images/media/5D83D85F-FC78-49AF-874B2C5E88AE38AA?w=768&h=768',
                                'external_url_small' => 'https://fondof.getbynder.com/images/media/5D83D85F-FC78-49AF-874B2C5E88AE38AA?w=384&h=384',
                                'image_sets' => [],
                            ],
                        ],
                    ],
                ]);

        $this->discountPromotionsRestApiConfigMock->expects(static::atLeastOnce())
            ->method('getImageSetByName')
            ->willReturn(false);

        $this->restResponseProductImageMapper->mapFromProductViewTransfer($this->productViewTransferMock);
    }
}
