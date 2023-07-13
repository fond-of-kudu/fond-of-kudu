<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductAbstractImageStorageTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\ProductImageStorage\ProductImageStorageClient;

class ProductImageStorageConnectorToProductImageStorageClientBridgeTest extends Unit
{
    /**
     * @var \Spryker\Client\ProductImageStorage\ProductImageStorageClient|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductImageStorageClient|MockObject $productImageStorageClientMock;

    /**
     * @var \Generated\Shared\Transfer\ProductAbstractImageStorageTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductAbstractImageStorageTransfer|MockObject$productAbstractImageStorageTransferMock;

    /**
     * @var \FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client\ProductImageStorageConnectorToProductImageStorageClientBridge
     */
    protected ProductImageStorageConnectorToProductImageStorageClientInterface $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->productImageStorageClientMock = $this->getMockBuilder(ProductImageStorageClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractImageStorageTransferMock = $this->getMockBuilder(ProductAbstractImageStorageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ProductImageStorageConnectorToProductImageStorageClientBridge($this->productImageStorageClientMock);
    }

    /**
     * @return void
     */
    public function testFindProductImageAbstractStorageTransfer(): void
    {
        $this->productImageStorageClientMock->expects(static::atLeastOnce())
            ->method('findProductImageAbstractStorageTransfer')
            ->with(99, 'de_DE')
            ->willReturn($this->productAbstractImageStorageTransferMock);

        $productAbstractImageStorageTransfer = $this->bridge->findProductImageAbstractStorageTransfer(99, 'de_DE');

        static::assertEquals($productAbstractImageStorageTransfer, $this->productAbstractImageStorageTransferMock);
    }
}
