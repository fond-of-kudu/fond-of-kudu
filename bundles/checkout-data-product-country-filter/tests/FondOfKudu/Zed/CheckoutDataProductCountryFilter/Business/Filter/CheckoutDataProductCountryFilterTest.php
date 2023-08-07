<?php

namespace FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\Filter;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfKudu\Zed\CheckoutDataProductCountryFilter\Dependency\Facade\CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeBridge;
use FondOfKudu\Zed\CheckoutDataProductCountryFilter\Dependency\Facade\CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeInterface;
use Generated\Shared\Transfer\BlacklistedCountryCollectionTransfer;
use Generated\Shared\Transfer\BlacklistedCountryTransfer;
use Generated\Shared\Transfer\CountryTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CheckoutDataProductCountryFilterTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\CheckoutDataProductCountryFilter\Dependency\Facade\CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeInterface|MockObject $productCountryRestrictionCheckoutConnectorFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestCheckoutDataTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCheckoutDataTransfer|MockObject $restCheckoutDataTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCheckoutRequestAttributesTransfer|MockObject $restCheckoutRequestAttributesTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\BlacklistedCountryCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected BlacklistedCountryCollectionTransfer|MockObject $blacklistedCountryCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\BlacklistedCountryTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected BlacklistedCountryTransfer|MockObject $blacklistedCountryTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CountryTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CountryTransfer|MockObject $countryTransferMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\Filter\CheckoutDataProductCountryFilterInterface
     */
    protected CheckoutDataProductCountryFilterInterface $checkoutDataProductCountryFilter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productCountryRestrictionCheckoutConnectorFacadeMock = $this
            ->getMockBuilder(CheckoutDataProductCountryFilterToProductCountryRestrictionCheckoutConnectorFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutDataTransferMock = $this
            ->getMockBuilder(RestCheckoutDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutRequestAttributesTransferMock = $this
            ->getMockBuilder(RestCheckoutRequestAttributesTransfer::class)
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

        $this->blacklistedCountryTransferMock = $this
            ->getMockBuilder(BlacklistedCountryTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryTransferMock = $this
            ->getMockBuilder(CountryTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutDataProductCountryFilter = new CheckoutDataProductCountryFilter(
            $this->productCountryRestrictionCheckoutConnectorFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFilterNoCountriesToRemove(): void
    {
        $this->restCheckoutDataTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->productCountryRestrictionCheckoutConnectorFacadeMock->expects(static::atLeastOnce())
            ->method('getBlacklistedCountryCollectionByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->blacklistedCountryCollectionTransferMock);

        $blacklistedCountries = new ArrayObject();
        $blacklistedCountries->append($this->blacklistedCountryTransferMock);

        $this->blacklistedCountryCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getBlacklistedCountries')
            ->willReturn($blacklistedCountries);

        $this->blacklistedCountryTransferMock->expects(static::atLeastOnce())
            ->method('getIso2Code')
            ->willReturn('CN');

        $this->restCheckoutDataTransferMock->expects(static::atLeastOnce())
            ->method('getCountries')
            ->willReturn([$this->countryTransferMock]);

        $this->countryTransferMock->expects(static::atLeastOnce())
            ->method('getIso2Code')
            ->willReturn('DE');

        $this->restCheckoutDataTransferMock->expects(static::atLeastOnce())
            ->method('setCountries')
            ->willReturnSelf();

        $restCheckoutDataTransfer = $this->checkoutDataProductCountryFilter->filter(
            $this->restCheckoutDataTransferMock,
            $this->restCheckoutRequestAttributesTransferMock,
        );

        static::assertEquals($restCheckoutDataTransfer, $this->restCheckoutDataTransferMock);
        static::assertCount(1, $restCheckoutDataTransfer->getCountries());
    }

    /**
     * @return void
     */
    public function testFilterNoQuote(): void
    {
        $this->restCheckoutDataTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn(null);

        $this->productCountryRestrictionCheckoutConnectorFacadeMock->expects(static::never())
            ->method('getBlacklistedCountryCollectionByQuote')
            ->willReturn($this->blacklistedCountryCollectionTransferMock);

        $restCheckoutDataTransfer = $this->checkoutDataProductCountryFilter->filter(
            $this->restCheckoutDataTransferMock,
            $this->restCheckoutRequestAttributesTransferMock,
        );

        static::assertEquals($restCheckoutDataTransfer, $this->restCheckoutDataTransferMock);
    }

    /**
     * @return void
     */
    public function testFilterNoBlacklistedCountries(): void
    {
        $this->restCheckoutDataTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->productCountryRestrictionCheckoutConnectorFacadeMock->expects(static::atLeastOnce())
            ->method('getBlacklistedCountryCollectionByQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->blacklistedCountryCollectionTransferMock);

        $this->blacklistedCountryCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getBlacklistedCountries')
            ->willReturn(new ArrayObject());

        $this->blacklistedCountryCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getBlacklistedCountries')
            ->willReturn(new ArrayObject());

        $restCheckoutDataTransfer = $this->checkoutDataProductCountryFilter->filter(
            $this->restCheckoutDataTransferMock,
            $this->restCheckoutRequestAttributesTransferMock,
        );

        static::assertEquals($restCheckoutDataTransfer, $this->restCheckoutDataTransferMock);
    }
}
