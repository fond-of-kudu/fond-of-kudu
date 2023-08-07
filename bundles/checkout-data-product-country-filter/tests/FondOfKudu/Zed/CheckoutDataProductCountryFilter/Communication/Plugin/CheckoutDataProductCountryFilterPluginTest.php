<?php

namespace FondOfKudu\Zed\CheckoutDataProductCountryFilter\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\CheckoutDataProductCountryFilterFacade;
use FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\CheckoutDataProductCountryFilterFacadeInterface;
use FondOfKudu\Zed\CheckoutRestApiCountryExtension\Dependency\Plugin\CheckoutRestApiCountryFilterPluginInterface;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CheckoutDataProductCountryFilterPluginTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\RestCheckoutDataTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCheckoutDataTransfer|MockObject $restCheckoutDataTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCheckoutRequestAttributesTransfer|MockObject $restCheckoutRequestAttributesTransferMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\CheckoutDataProductCountryFilterFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CheckoutDataProductCountryFilterFacadeInterface|MockObject $checkoutDataProductCountryFilterFacade;

    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryExtension\Dependency\Plugin\CheckoutRestApiCountryFilterPluginInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CheckoutRestApiCountryFilterPluginInterface|MockObject $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restCheckoutDataTransferMock = $this
            ->getMockBuilder(RestCheckoutDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutRequestAttributesTransferMock = $this
            ->getMockBuilder(RestCheckoutRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutDataProductCountryFilterFacade = $this
            ->getMockBuilder(CheckoutDataProductCountryFilterFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CheckoutDataProductCountryFilterPlugin();
        $this->plugin->setFacade($this->checkoutDataProductCountryFilterFacade);
    }

    /**
     * @return void
     */
    public function testFilter(): void
    {
        $this->checkoutDataProductCountryFilterFacade->expects(static::atLeastOnce())
            ->method('filter')
            ->with($this->restCheckoutDataTransferMock, $this->restCheckoutRequestAttributesTransferMock)
            ->willReturn($this->restCheckoutDataTransferMock);

        static::assertEquals($this->restCheckoutDataTransferMock, $this->plugin->filter(
            $this->restCheckoutDataTransferMock,
            $this->restCheckoutRequestAttributesTransferMock,
        ));
    }
}
