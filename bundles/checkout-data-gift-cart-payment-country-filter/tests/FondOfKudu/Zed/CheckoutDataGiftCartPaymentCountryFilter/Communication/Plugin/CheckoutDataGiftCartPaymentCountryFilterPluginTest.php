<?php

namespace FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Communication\Plugin;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business\CheckoutDataGiftCartPaymentCountryFilterFacade;
use FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business\CheckoutDataGiftCartPaymentCountryFilterFacadeInterface;
use FondOfKudu\Zed\CheckoutRestApiCountryExtension\Dependency\Plugin\CheckoutRestApiCountryFilterPluginInterface;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CheckoutDataGiftCartPaymentCountryFilterPluginTest extends Unit
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
     * @var CheckoutDataGiftCartPaymentCountryFilterFacadeInterface|MockObject
     */
    protected CheckoutDataGiftCartPaymentCountryFilterFacadeInterface|MockObject $checkoutDataGiftCartPaymentCountryFilterFacadeMock;

    /**
     * @var CheckoutRestApiCountryFilterPluginInterface
     */
    protected CheckoutRestApiCountryFilterPluginInterface $checkoutDataGiftCartPaymentCountryFilterPlugin;

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

        $this->checkoutDataGiftCartPaymentCountryFilterFacadeMock = $this
            ->getMockBuilder(CheckoutDataGiftCartPaymentCountryFilterFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutDataGiftCartPaymentCountryFilterPlugin = new CheckoutDataGiftCartPaymentCountryFilterPlugin();
        $this->checkoutDataGiftCartPaymentCountryFilterPlugin->setFacade($this->checkoutDataGiftCartPaymentCountryFilterFacadeMock);
    }

    /**
     * @return void
     */
    public function testFilter(): void
    {
        $this->checkoutDataGiftCartPaymentCountryFilterFacadeMock->expects(static::atLeastOnce())
            ->method('filter')
            ->with($this->restCheckoutDataTransferMock, $this->restCheckoutRequestAttributesTransferMock)
            ->willReturn($this->restCheckoutDataTransferMock);

        $restCheckoutDataTransferMock = $this->checkoutDataGiftCartPaymentCountryFilterPlugin->filter(
            $this->restCheckoutDataTransferMock,
            $this->restCheckoutRequestAttributesTransferMock
        );

        static::assertEquals($restCheckoutDataTransferMock, $this->restCheckoutDataTransferMock);
    }
}
