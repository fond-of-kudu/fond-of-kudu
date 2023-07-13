<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Plugin;

use Codeception\Test\Unit;
use FondOfKudu\Client\ProductImageStorageConnector\Expander\ProductViewImageCustomSetsExpander;
use FondOfKudu\Client\ProductImageStorageConnector\Expander\ProductViewImageCustomSetsExpanderInterface;
use FondOfKudu\Client\ProductImageStorageConnector\ProductImageStorageConnectorFactory;
use Generated\Shared\Transfer\ProductViewTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\ProductStorageExtension\Dependency\Plugin\ProductViewExpanderPluginInterface;

class ProductViewImageCustomSetExpanderPluginTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\ProductViewTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductViewTransfer|MockObject $productViewTransferMock;

    /**
     * @var \FondOfKudu\Client\ProductImageStorageConnector\ProductImageStorageConnectorFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductImageStorageConnectorFactory|MockObject $factoryMock;

    /**
     * @var \FondOfKudu\Client\ProductImageStorageConnector\Expander\ProductViewImageCustomSetsExpanderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductViewImageCustomSetsExpanderInterface|MockObject $productViewImageCustomSetsExpanderMock;

    /**
     * @var \Spryker\Client\ProductStorageExtension\Dependency\Plugin\ProductViewExpanderPluginInterface
     */
    protected ProductViewExpanderPluginInterface $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productViewTransferMock = $this->getMockBuilder(ProductViewTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(ProductImageStorageConnectorFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productViewImageCustomSetsExpanderMock = $this->getMockBuilder(ProductViewImageCustomSetsExpander::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductViewImageCustomSetExpanderPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandProductViewTransfer(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createProductViewImageCustomSetsExpander')
            ->willReturn($this->productViewImageCustomSetsExpanderMock);

        $this->productViewImageCustomSetsExpanderMock->expects(static::atLeastOnce())
            ->method('expandProductViewTransfer')
            ->with($this->productViewTransferMock, [], 'de_DE')
            ->willReturn($this->productViewTransferMock);

        $productViewTransfer = $this->plugin->expandProductViewTransfer($this->productViewTransferMock, [], 'de_DE');

        static::assertEquals($productViewTransfer, $this->productViewTransferMock);
    }
}
