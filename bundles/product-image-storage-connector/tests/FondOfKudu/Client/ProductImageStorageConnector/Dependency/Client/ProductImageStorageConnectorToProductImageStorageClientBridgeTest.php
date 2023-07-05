<?php

namespace FondOfKudu\Client\ProductImageStorageConnector\Dependency\Client;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductAbstractImageStorageTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\ProductImageStorage\ProductImageStorageClient;

class ProductImageStorageConnectorToProductImageStorageClientBridgeTest extends Unit
{
    /**
     * @var ProductImageStorageClient|MockObject
     */
    protected $imageStorageClientMock;

    /**
     * @var ProductAbstractImageStorageTransfer|MockObject
     */
    protected $productAbstractImageStorageTransferMock;

    /**
     * @var ProductImageStorageConnectorToProductImageStorageClientBridge
     */
    protected $client;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->imageStorageClientMock = $this->getMockBuilder(ProductImageStorageClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractImageStorageTransferMock = $this->getMockBuilder(ProductAbstractImageStorageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new ProductImageStorageConnectorToProductImageStorageClientBridge($this->imageStorageClientMock);
    }

    /**
     * @return void
     */
    public function testFindProductImageAbstractStorageTransfer(): void
    {
        static::assertEquals(
            $this->productAbstractImageStorageTransferMock,
            $this->client->findProductImageAbstractStorageTransfer(99, 'de_DE')
        );
    }
}
