<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CheckoutDataExpander;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class CheckoutRestApiCountryConnectorFacadeTest extends Unit
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
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\Expander\CheckoutDataExpander|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $checkoutDataExpanderMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\CheckoutRestApiCountryConnectorBusinessFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $factoryMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\CheckoutRestApiCountryConnectorFacade
     */
    protected $facade;

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

        $this->checkoutDataExpanderMock = $this->getMockBuilder(CheckoutDataExpander::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(CheckoutRestApiCountryConnectorBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CheckoutRestApiCountryConnectorFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpandCheckoutDataWithCountries(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCheckoutDataExpander')
            ->willReturn($this->checkoutDataExpanderMock);

        $this->checkoutDataExpanderMock->expects(static::atLeastOnce())
            ->method('expandCheckoutDataWithCountries')
            ->with($this->restCheckoutDataTransferMock, $this->restCheckoutRequestAttributesTransferMock)
            ->willReturn($this->restCheckoutDataTransferMock);

        $restCheckoutDataTransfer = $this->facade->expandCheckoutDataWithCountries(
            $this->restCheckoutDataTransferMock,
            $this->restCheckoutRequestAttributesTransferMock,
        );

        static::assertEquals($restCheckoutDataTransfer, $this->restCheckoutDataTransferMock);
    }
}
