<?php

namespace FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business\Filter;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\CheckoutDataGiftCartPaymentCountryFilterConfig;
use Generated\Shared\Transfer\CountryTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CheckoutDataGiftCartPaymentCountryFilterTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\CheckoutDataGiftCartPaymentCountryFilterConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CheckoutDataGiftCartPaymentCountryFilterConfig|MockObject $checkoutDataGiftCartPaymentCountryFilterConfigMock;

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
     * @var \Generated\Shared\Transfer\CountryTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CountryTransfer|MockObject $countryTransferMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business\Filter\CheckoutDataGiftCartPaymentCountryFilterInterface
     */
    protected CheckoutDataGiftCartPaymentCountryFilterInterface $checkoutDataGiftCartPaymentCountryFilter;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->checkoutDataGiftCartPaymentCountryFilterConfigMock = $this
            ->getMockBuilder(CheckoutDataGiftCartPaymentCountryFilterConfig::class)
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

        $this->countryTransferMock = $this
            ->getMockBuilder(CountryTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutDataGiftCartPaymentCountryFilter = new CheckoutDataGiftCartPaymentCountryFilter(
            $this->checkoutDataGiftCartPaymentCountryFilterConfigMock,
        );
    }

    /**
     * @return void
     */
    public function testFilterNoQuote(): void
    {
        $this->restCheckoutDataTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn(null);

        $this->checkoutDataGiftCartPaymentCountryFilterConfigMock->expects(static::never())
            ->method('getBlacklistedCountries');

        $restCheckoutDataTransfer = $this->checkoutDataGiftCartPaymentCountryFilter->filter(
            $this->restCheckoutDataTransferMock,
            $this->restCheckoutRequestAttributesTransferMock,
        );

        static::assertEquals($restCheckoutDataTransfer, $this->restCheckoutDataTransferMock);
    }

    /**
     * @return void
     */
    public function testFilterNoBlacklistetCountries(): void
    {
        $this->restCheckoutDataTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->checkoutDataGiftCartPaymentCountryFilterConfigMock->expects(static::atLeastOnce())
            ->method('getBlacklistedCountries')
            ->willReturn([]);

        $this->restCheckoutDataTransferMock->expects(static::never())
            ->method('getCountries');

        $restCheckoutDataTransfer = $this->checkoutDataGiftCartPaymentCountryFilter->filter(
            $this->restCheckoutDataTransferMock,
            $this->restCheckoutRequestAttributesTransferMock,
        );

        static::assertEquals($restCheckoutDataTransfer, $this->restCheckoutDataTransferMock);
    }

    /**
     * @return void
     */
    public function testFilter(): void
    {
        $this->restCheckoutDataTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->checkoutDataGiftCartPaymentCountryFilterConfigMock->expects(static::atLeastOnce())
            ->method('getBlacklistedCountries')
            ->willReturn(['CN']);

        $this->restCheckoutDataTransferMock->expects(static::atLeastOnce())
            ->method('getCountries')
            ->willReturn([$this->countryTransferMock]);

        $this->countryTransferMock->expects(static::atLeastOnce())
            ->method('getIso2Code')
            ->willReturn('CN');

        $this->restCheckoutDataTransferMock->expects(static::atLeastOnce())
            ->method('setCountries')
            ->willReturnSelf();

        $restCheckoutDataTransfer = $this->checkoutDataGiftCartPaymentCountryFilter->filter(
            $this->restCheckoutDataTransferMock,
            $this->restCheckoutRequestAttributesTransferMock,
        );

        static::assertEquals($restCheckoutDataTransfer, $this->restCheckoutDataTransferMock);
    }
}
