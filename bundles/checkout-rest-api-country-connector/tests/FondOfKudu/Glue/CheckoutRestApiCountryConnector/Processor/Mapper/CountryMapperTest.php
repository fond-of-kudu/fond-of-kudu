<?php

namespace FondOfKudu\Glue\CheckoutRestApiCountryConnector\Processor\Mapper;

use Codeception\Test\Unit;
use FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToGlossaryStorageClientBridge;
use FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToLocaleClientBridge;
use Generated\Shared\Transfer\CountryTransfer;
use Generated\Shared\Transfer\RestCheckoutDataResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CountryMapperTest extends Unit
{
    /**
     * @var \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToLocaleClientBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $localeClientMock;

    /**
     * @var \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToGlossaryStorageClientBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $glossaryStorageClientMock;

    /**
     * @var \Generated\Shared\Transfer\RestCheckoutDataTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCheckoutDataTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCheckoutRequestAttributesTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCheckoutDataResponseAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $restCheckoutDataResponseAttributesTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CountryTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $countryTransferMock;

    /**
     * @var \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Processor\Mapper\CountryMapper
     */
    protected $countryMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->localeClientMock = $this->getMockBuilder(CheckoutRestApiCountryConnectorToLocaleClientBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->glossaryStorageClientMock = $this->getMockBuilder(CheckoutRestApiCountryConnectorToGlossaryStorageClientBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutDataTransferMock = $this->getMockBuilder(RestCheckoutDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutRequestAttributesTransferMock = $this->getMockBuilder(RestCheckoutRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutDataResponseAttributesTransferMock = $this->getMockBuilder(RestCheckoutDataResponseAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryTransferMock = $this->getMockBuilder(CountryTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryMapper = new CountryMapper($this->glossaryStorageClientMock, $this->localeClientMock);
    }

    /**
     * @return void
     */
    public function testMapRestCheckoutDataResponseTransferToRestCheckoutDataResponseAttributesTransfer(): void
    {
        $this->restCheckoutDataTransferMock->expects(static::atLeastOnce())
            ->method('getCountries')
            ->willReturn([$this->countryTransferMock, $this->countryTransferMock]);

        $this->countryTransferMock->expects(static::atLeastOnce())
            ->method('getIdCountry')
            ->willReturnOnConsecutiveCalls(11, 22);

        $this->countryTransferMock->expects(static::atLeastOnce())
            ->method('getIso2Code')
            ->willReturnOnConsecutiveCalls('DE', 'FR', 'DE', 'FR');

        $this->localeClientMock->expects(static::atLeastOnce())
            ->method('getCurrentLocale')
            ->willReturn('DE');

        $this->glossaryStorageClientMock->expects(static::atLeastOnce())
            ->method('translate')
            ->willReturnOnConsecutiveCalls(
                'Deutschland',
                'Frankreich',
            );

        $this->restCheckoutDataResponseAttributesTransferMock->expects(static::atLeastOnce())
            ->method('addCountry')
            ->willReturnSelf();

        $restCheckoutDataResponseAttributesTransfer = $this->countryMapper
            ->mapRestCheckoutDataResponseTransferToRestCheckoutDataResponseAttributesTransfer(
                $this->restCheckoutDataTransferMock,
                $this->restCheckoutRequestAttributesTransferMock,
                $this->restCheckoutDataResponseAttributesTransferMock,
            );

        static::assertEquals($restCheckoutDataResponseAttributesTransfer, $this->restCheckoutDataResponseAttributesTransferMock);
    }
}
