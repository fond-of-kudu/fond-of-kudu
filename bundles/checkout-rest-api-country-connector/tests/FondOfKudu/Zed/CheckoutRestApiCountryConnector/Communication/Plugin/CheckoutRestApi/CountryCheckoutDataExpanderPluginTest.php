<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Communication\Plugin\CheckoutRestApi;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\CheckoutRestApiCountryConnectorFacade;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CountryCheckoutDataExpanderPluginTest extends Unit
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
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\CheckoutRestApiCountryConnectorFacade|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $checkoutRestApiCountryConnectorFacadeMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Communication\Plugin\CheckoutRestApi\CountryCheckoutDataExpanderPlugin
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

        $this->checkoutRestApiCountryConnectorFacadeMock = $this->getMockBuilder(CheckoutRestApiCountryConnectorFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CountryCheckoutDataExpanderPlugin();
        $this->plugin->setFacade($this->checkoutRestApiCountryConnectorFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpandCheckoutData(): void
    {
        $this->checkoutRestApiCountryConnectorFacadeMock->expects(static::atLeastOnce())
            ->method('expandCheckoutDataWithCountries')
            ->with(
                $this->restCheckoutDataTransferMock,
                $this->restCheckoutRequestAttributesTransferMock,
            )
            ->willReturn($this->restCheckoutDataTransferMock);

        $restCheckoutDataTransfer = $this->plugin->expandCheckoutData(
            $this->restCheckoutDataTransferMock,
            $this->restCheckoutRequestAttributesTransferMock,
        );

        static::assertEquals($restCheckoutDataTransfer, $this->restCheckoutDataTransferMock);
    }
}
