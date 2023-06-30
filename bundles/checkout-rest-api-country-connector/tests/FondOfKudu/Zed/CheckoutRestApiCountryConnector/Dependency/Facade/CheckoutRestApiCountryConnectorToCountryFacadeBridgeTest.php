<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CountryTransfer;
use Spryker\Zed\Country\Business\CountryFacade;

class CheckoutRestApiCountryConnectorToCountryFacadeBridgeTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\CountryTransfer|\FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\MockObject
     */
    protected $countryTransferMock;

    /**
     * @var \Spryker\Zed\Country\Business\CountryFacade|\FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\MockObject
     */
    protected $countryFacadeMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeBridge
     */
    protected $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->countryTransferMock = $this->getMockBuilder(CountryTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryFacadeMock = $this->getMockBuilder(CountryFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CheckoutRestApiCountryConnectorToCountryFacadeBridge($this->countryFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetCountryByIso2Code(): void
    {
        $this->countryFacadeMock->expects(static::atLeastOnce())
            ->method('getCountryByIso2Code')
            ->willReturn($this->countryTransferMock);

        $this->bridge->getCountryByIso2Code('de_DE');
    }
}
