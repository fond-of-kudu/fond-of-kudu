<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeBridge;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToStoreFacadeBridge;
use Generated\Shared\Transfer\CountryTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Generated\Shared\Transfer\StoreTransfer;

class CheckoutDataExpanderTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToStoreFacadeBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeFacadeMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $countryFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\RestCheckoutDataTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCheckoutDataTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCheckoutRequestAttributesTransferMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\StoreTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CountryTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $countryTransferMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CheckoutDataExpander
     */
    protected $expander;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->storeFacadeMock = $this->getMockBuilder(CheckoutRestApiCountryConnectorToStoreFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryFacadeMock = $this->getMockBuilder(CheckoutRestApiCountryConnectorToCountryFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutDataTransferMock = $this->getMockBuilder(RestCheckoutDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutRequestAttributesTransferMock = $this->getMockBuilder(RestCheckoutRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryTransferMock = $this->getMockBuilder(CountryTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeTransferMock = $this->getMockBuilder(StoreTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expander = new CheckoutDataExpander(
            $this->storeFacadeMock,
            $this->countryFacadeMock,
            [],
        );
    }

    /**
     * @return void
     */
    public function testExpandCheckoutDataWithCountries(): void
    {
        $this->restCheckoutDataTransferMock->expects(static::atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->storeFacadeMock->expects(static::atLeastOnce())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransferMock);

        $this->storeTransferMock->expects(static::atLeastOnce())
            ->method('getCountries')
            ->willReturn(['DE']);

        $this->countryFacadeMock->expects(static::atLeastOnce())
            ->method('getCountryByIso2Code')
            ->with('DE')
            ->willReturn($this->countryTransferMock);

        $this->restCheckoutDataTransferMock->expects(static::atLeastOnce())
            ->method('addCountry')
            ->with($this->countryTransferMock)
            ->willReturnSelf();

        $restCheckoutDataTransfer = $this->expander->expandCheckoutDataWithCountries(
            $this->restCheckoutDataTransferMock,
            $this->restCheckoutRequestAttributesTransferMock,
        );

        static::assertEquals($restCheckoutDataTransfer, $this->restCheckoutDataTransferMock);
    }
}
