<?php

namespace FondOfKudu\Zed\CheckoutDataProductCountryFilter\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfOryx\Zed\ProductCountryRestrictionCheckoutConnector\Business\ProductCountryRestrictionCheckoutConnectorFacade;
use Generated\Shared\Transfer\BlacklistedCountryCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfOryx\Zed\ProductCountryRestrictionCheckoutConnector\Business\ProductCountryRestrictionCheckoutConnectorFacade|\PHPUnit\Framework\MockObject\MockObject
     */
    protected ProductCountryRestrictionCheckoutConnectorFacade|MockObject $productCountryRestrictionCheckoutConnectorFacade;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\BlacklistedCountryCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected BlacklistedCountryCollectionTransfer|MockObject $blacklistedCountryCollectionTransferMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutDataProductCountryFilter\Dependency\Facade\CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeInterface
     */
    protected CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeInterface $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productCountryRestrictionCheckoutConnectorFacade = $this
            ->getMockBuilder(ProductCountryRestrictionCheckoutConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this
            ->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->blacklistedCountryCollectionTransferMock = $this
            ->getMockBuilder(BlacklistedCountryCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeBridge(
            $this->productCountryRestrictionCheckoutConnectorFacade,
        );
    }

    /**
     * @return void
     */
    public function testGetBlacklistedCountryCollectionByQuote(): void
    {
        $this->productCountryRestrictionCheckoutConnectorFacade->expects(static::atLeastOnce())
            ->method('getBlacklistedCountryCollectionByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->blacklistedCountryCollectionTransferMock);

        $blacklistedCountryCollectionTransfer = $this->bridge
            ->getBlacklistedCountryCollectionByQuote($this->quoteTransferMock);

        static::assertEquals($blacklistedCountryCollectionTransfer, $this->blacklistedCountryCollectionTransferMock);
    }
}
