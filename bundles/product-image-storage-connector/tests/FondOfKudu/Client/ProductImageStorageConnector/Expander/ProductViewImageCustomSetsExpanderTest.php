<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Expander;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientBridge;
use FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientInterface;
use FondOfKudu\Client\ProductImageStorageConnector\ProductImageStorageConnectorConfig;
use FondOfKudu\Shared\ProductImageStorageConnector\ProductImageStorageConnectorConstants;
use Generated\Shared\Transfer\ProductAbstractImageStorageTransfer;
use Generated\Shared\Transfer\ProductImageSetStorageTransfer;
use Generated\Shared\Transfer\ProductImageStorageTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ProductViewImageCustomSetsExpanderTest extends Unit
{
    /**
     * @var \FondOfKudu\Client\ProductImageStorageConnector\ProductImageStorageConnectorConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductImageStorageConnectorConfig|MockObject $configMock;

    /**
     * @var \FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductImageStorageConnectorToProductImageStorageClientInterface|MockObject $connectorToProductImageStorageClientMock;

    /**
     * @var \Generated\Shared\Transfer\ProductViewTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductViewTransfer|MockObject $productViewTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ProductAbstractImageStorageTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductAbstractImageStorageTransfer|MockObject $productAbstractImageStorageTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ProductImageSetStorageTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductImageSetStorageTransfer|MockObject $productImageSetStorageTransferMock;

    protected ProductImageStorageTransfer|MockObject $productImageStorageTransferMock;

    /**
     * @var \FondOfKudu\Client\ProductImageStorageConnector\Expander\ProductViewImageCustomSetsExpanderInterface
     */
    protected ProductViewImageCustomSetsExpanderInterface $expander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configMock = $this->getMockBuilder(ProductImageStorageConnectorConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->connectorToProductImageStorageClientMock = $this->getMockBuilder(ProductImageStorageConnectorToProductImageStorageClientBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productViewTransferMock = $this->getMockBuilder(ProductViewTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractImageStorageTransferMock = $this->getMockBuilder(ProductAbstractImageStorageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productImageSetStorageTransferMock = $this->getMockBuilder(ProductImageSetStorageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productImageStorageTransferMock = $this->getMockBuilder(ProductImageStorageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new ProductViewImageCustomSetsExpander($this->configMock, $this->connectorToProductImageStorageClientMock);
    }

    /**
     * @return void
     */
    public function testExpandProductViewTransfer(): void
    {
        $this->configMock->expects(static::atLeastOnce())
            ->method('getImageSets')
            ->willReturn([
                ProductImageStorageConnectorConstants::IMAGE_SET_ADDITIONAL,
                ProductImageStorageConnectorConstants::IMAGE_SET_THUMBNAIL,
                ProductImageStorageConnectorConstants::IMAGE_SET_BASEIMAGE,
                ProductImageStorageConnectorConstants::IMAGE_SET_HOVERIMAGE,
                ProductImageStorageConnectorConstants::IMAGE_SET_SETIMAGE,
            ]);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(99);

        $this->connectorToProductImageStorageClientMock->expects(static::atLeastOnce())
            ->method('findProductImageAbstractStorageTransfer')
            ->with(99, 'de_DE')
            ->willReturn($this->productAbstractImageStorageTransferMock);

        $arrayObject = new ArrayObject();
        $arrayObject->append($this->productImageSetStorageTransferMock);

        $this->productAbstractImageStorageTransferMock->expects(static::atLeastOnce())
            ->method('getImageSets')
            ->willReturn($arrayObject);

        $this->productImageSetStorageTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn(ProductImageStorageConnectorConstants::IMAGE_SET_ADDITIONAL);

        $productViewTransfer = $this->expander->expandProductViewTransfer($this->productViewTransferMock, [], 'de_DE');

        static::assertEquals($productViewTransfer, $this->productViewTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandProductViewTransferNoImagesSets(): void
    {
        $this->configMock->expects(static::atLeastOnce())
            ->method('getImageSets')
            ->willReturn([
                ProductImageStorageConnectorConstants::IMAGE_SET_ADDITIONAL,
                ProductImageStorageConnectorConstants::IMAGE_SET_THUMBNAIL,
                ProductImageStorageConnectorConstants::IMAGE_SET_BASEIMAGE,
                ProductImageStorageConnectorConstants::IMAGE_SET_HOVERIMAGE,
                ProductImageStorageConnectorConstants::IMAGE_SET_SETIMAGE,
            ]);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(99);

        $this->connectorToProductImageStorageClientMock->expects(static::atLeastOnce())
            ->method('findProductImageAbstractStorageTransfer')
            ->with(99, 'de_DE')
            ->wilLReturn(null);

        $productViewTransfer = $this->expander->expandProductViewTransfer($this->productViewTransferMock, [], 'de_DE');

        static::assertEquals($productViewTransfer, $this->productViewTransferMock);
    }

    /**
     * @return void
     */
    public function testExpandProductViewTransferWithinDefault(): void
    {
        $configImageSets = [
            ProductImageStorageConnectorConstants::IMAGE_SET_ADDITIONAL,
            ProductImageStorageConnectorConstants::IMAGE_SET_THUMBNAIL,
            ProductImageStorageConnectorConstants::IMAGE_SET_BASEIMAGE,
            ProductImageStorageConnectorConstants::IMAGE_SET_HOVERIMAGE,
            ProductImageStorageConnectorConstants::IMAGE_SET_SETIMAGE,
        ];

        $this->configMock->expects(static::atLeastOnce())
            ->method('getImageSets')
            ->willReturn($configImageSets);

        $this->configMock->expects(static::atLeastOnce())
            ->method('allwaysDefaultImageSet')
            ->willReturn(true);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(99);

        $this->connectorToProductImageStorageClientMock->expects(static::atLeastOnce())
            ->method('findProductImageAbstractStorageTransfer')
            ->with(99, 'de_DE')
            ->willReturn($this->productAbstractImageStorageTransferMock);

        $arrayObject = new ArrayObject();
        $arrayObject->append($this->productImageSetStorageTransferMock);

        $this->productAbstractImageStorageTransferMock->expects(static::atLeastOnce())
            ->method('getImageSets')
            ->willReturn($arrayObject);

        $this->productImageSetStorageTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn(ProductImageStorageConnectorConstants::IMAGE_SET_ADDITIONAL);

        $productViewTransfer = $this->expander->expandProductViewTransfer($this->productViewTransferMock, [], 'de_DE');

        static::assertEquals($productViewTransfer, $this->productViewTransferMock);
    }
}
