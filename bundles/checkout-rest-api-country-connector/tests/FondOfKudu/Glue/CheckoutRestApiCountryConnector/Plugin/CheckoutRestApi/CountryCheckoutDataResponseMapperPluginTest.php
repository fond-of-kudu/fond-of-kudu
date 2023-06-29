<?php

namespace FondOfKudu\Glue\CheckoutRestApiCountryConnector\Plugin\CheckoutRestApi;

use Codeception\Test\Unit;
use FondOfKudu\Glue\CheckoutRestApiCountryConnector\CheckoutRestApiCountryConnectorFactory;
use FondOfKudu\Glue\CheckoutRestApiCountryConnector\Processor\Mapper\CountryMapper;
use Generated\Shared\Transfer\RestCheckoutDataResponseAttributesTransfer;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CountryCheckoutDataResponseMapperPluginTest extends Unit
{
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
    protected $restCheckoutResponseAttributesTransferMock;

    /**
     * @var \FondOfKudu\Glue\CheckoutRestApiCountryConnector\CheckoutRestApiCountryConnectorFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $factoryMock;

    /**
     * @var \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Processor\Mapper\CountryMapper|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $countryMapperMock;

    /**
     * @var \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Plugin\CheckoutRestApi\CountryCheckoutDataResponseMapperPlugin
     */
    protected $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restCheckoutDataTransferMock = $this->getMockBuilder(RestCheckoutDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutRequestAttributesTransferMock = $this->getMockBuilder(RestCheckoutRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutResponseAttributesTransferMock = $this->getMockBuilder(RestCheckoutDataResponseAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(CheckoutRestApiCountryConnectorFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryMapperMock = $this->getMockBuilder(CountryMapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CountryCheckoutDataResponseMapperPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testMapRestCheckoutDataResponseTransferToRestCheckoutDataResponseAttributesTransfer(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCountryMapper')
            ->willReturn($this->countryMapperMock);

        $this->countryMapperMock->expects(static::atLeastOnce())
            ->method('mapRestCheckoutDataResponseTransferToRestCheckoutDataResponseAttributesTransfer')
            ->willReturn($this->restCheckoutResponseAttributesTransferMock);

        $restCheckoutResponseAttributesTransfer = $this->plugin
            ->mapRestCheckoutDataResponseTransferToRestCheckoutDataResponseAttributesTransfer(
                $this->restCheckoutDataTransferMock,
                $this->restCheckoutRequestAttributesTransferMock,
                $this->restCheckoutResponseAttributesTransferMock,
            );

        static::assertEquals(
            $restCheckoutResponseAttributesTransfer,
            $this->restCheckoutResponseAttributesTransferMock,
        );
    }
}
