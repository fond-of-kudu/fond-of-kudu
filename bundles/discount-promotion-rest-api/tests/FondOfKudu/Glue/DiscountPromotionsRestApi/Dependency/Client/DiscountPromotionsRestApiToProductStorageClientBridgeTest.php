<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductViewTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\ProductStorage\ProductStorageClient;
use Spryker\Client\ProductStorage\ProductStorageClientInterface;

class DiscountPromotionsRestApiToProductStorageClientBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ProductStorage\ProductStorageClientInterface
     */
    protected MockObject|ProductStorageClientInterface $productStorageClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductViewTransfer
     */
    protected MockObject|ProductViewTransfer $productViewTransferMock;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToProductStorageClientInterface
     */
    protected DiscountPromotionsRestApiToProductStorageClientInterface $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productStorageClientMock = $this->getMockBuilder(ProductStorageClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productViewTransferMock = $this->getMockBuilder(ProductViewTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new DiscountPromotionsRestApiToProductStorageClientBridge($this->productStorageClientMock);
    }

    /**
     * @return void
     */
    public function testFindProductAbstractViewTransfer(): void
    {
        $this->productStorageClientMock->expects(static::atLeastOnce())
            ->method('findProductAbstractViewTransfer')
            ->with(99, 'de_DE')
            ->willReturn($this->productViewTransferMock);

        $productViewTransfer = $this->bridge->findProductAbstractViewTransfer(99, 'de_DE');

        static::assertEquals($productViewTransfer, $this->productViewTransferMock);
    }
}
