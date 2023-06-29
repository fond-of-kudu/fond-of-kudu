<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfOryx\Zed\ProductCountryRestrictionCheckoutConnector\Business\ProductCountryRestrictionCheckoutConnectorFacade;
use Generated\Shared\Transfer\BlacklistedCountryCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfOryx\Zed\ProductCountryRestrictionCheckoutConnector\Business\ProductCountryRestrictionCheckoutConnectorFacade|\FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\MockObject
     */
    protected $productCountryRestrictionCheckoutConnectorFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\BlacklistedCountryCollectionTransfer|\FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\MockObject
     */
    protected $blacklistedCountryCollectionTransfer;

    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeBridge
     */
    protected $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productCountryRestrictionCheckoutConnectorFacadeMock = $this->getMockBuilder(ProductCountryRestrictionCheckoutConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->blacklistedCountryCollectionTransfer = $this->getMockBuilder(BlacklistedCountryCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CheckoutRestApiCountryConnectorToProductCountryRestrictionCheckoutConnectorFacadeBridge(
            $this->productCountryRestrictionCheckoutConnectorFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testGetBlacklistedCountryCollectionByQuote(): void
    {
        $this->productCountryRestrictionCheckoutConnectorFacadeMock->expects(static::atLeastOnce())
            ->method('getBlacklistedCountryCollectionByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->blacklistedCountryCollectionTransfer);

        $this->bridge->getBlacklistedCountryCollectionByQuote(
            $this->quoteTransferMock,
        );
    }
}
