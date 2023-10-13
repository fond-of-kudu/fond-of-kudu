<?php

namespace FondOfKudu\Zed\CartsRestApi\Communication\Plugin;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfKudu\Client\CartsRestApi\CartsRestApiClient;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCartsAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ResetCartAttributesMapperPluginTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\CartsRestApi\Communication\Plugin\ResetCartAttributesMapperPlugin
     */
    protected ResetCartAttributesMapperPlugin $resetCartAttributesMapperPlugin;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCartsAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|RestCartsAttributesTransfer $restCartsAttributesTransferMock;

    /**
     * @var \FondOfKudu\Client\CartsRestApi\CartsRestApiClient|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CartsRestApiClient|MockObject $cartsRestApiClientMock;

    /**
     * @var \Generated\Shared\Transfer\ItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|ItemTransfer $itemTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCartsAttributesTransferMock = $this->getMockBuilder(RestCartsAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cartsRestApiClientMock = $this->getMockBuilder(CartsRestApiClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resetCartAttributesMapperPlugin = new ResetCartAttributesMapperPlugin();
        $this->resetCartAttributesMapperPlugin->setClient($this->cartsRestApiClientMock);
    }

    /**
     * @return void
     */
    public function testMapQuoteTransferToRestCartAttributesTransfer(): void
    {
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([
                $this->itemTransferMock,
            ]));

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getIdSalesOrderItem')
            ->willReturn(null);

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getOrderReference')
            ->willReturn(null);

        $restCartsAttributesTransfer = $this->resetCartAttributesMapperPlugin->mapQuoteTransferToRestCartAttributesTransfer(
            $this->quoteTransferMock,
            $this->restCartsAttributesTransferMock,
        );

        $this->assertSame($this->restCartsAttributesTransferMock, $restCartsAttributesTransfer);
    }

    /**
     * @return void
     */
    public function testMapQuoteTransferToRestCartAttributesTransferOrderReference(): void
    {
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([
                $this->itemTransferMock,
            ]));

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getIdSalesOrderItem')
            ->willReturn(null);

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getOrderReference')
            ->willReturn('order-reference');

        $this->cartsRestApiClientMock->expects($this->atLeastOnce())
            ->method('resetQuote')
            ->with($this->quoteTransferMock);

        $restCartsAttributesTransfer = $this->resetCartAttributesMapperPlugin->mapQuoteTransferToRestCartAttributesTransfer(
            $this->quoteTransferMock,
            $this->restCartsAttributesTransferMock,
        );

        $this->assertSame($this->restCartsAttributesTransferMock, $restCartsAttributesTransfer);
    }

    /**
     * @return void
     */
    public function testMapQuoteTransferToRestCartAttributesTransferIdSalesOrderItem(): void
    {
        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([
                $this->itemTransferMock,
            ]));

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getIdSalesOrderItem')
            ->willReturn(1234);

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getOrderReference')
            ->willReturn(null);

        $this->cartsRestApiClientMock->expects($this->atLeastOnce())
            ->method('resetQuote')
            ->with($this->quoteTransferMock);

        $restCartsAttributesTransfer = $this->resetCartAttributesMapperPlugin->mapQuoteTransferToRestCartAttributesTransfer(
            $this->quoteTransferMock,
            $this->restCartsAttributesTransferMock,
        );

        $this->assertSame($this->restCartsAttributesTransferMock, $restCartsAttributesTransfer);
    }
}
