<?php

namespace FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business\Filter\CheckoutDataGiftCartPaymentCountryFilter;
use FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business\Filter\CheckoutDataGiftCartPaymentCountryFilterInterface;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use function Symfony\Component\Translation\t;

class CheckoutDataGiftCartPaymentCountryFilterFacadeTest extends Unit
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
     * @var CheckoutDataGiftCartPaymentCountryFilterBusinessFactory|MockObject
     */
    protected CheckoutDataGiftCartPaymentCountryFilterBusinessFactory|MockObject $checkoutDataGiftCartPaymentCountryFilterBusinessFactoryMock;

    /**
     * @var CheckoutDataGiftCartPaymentCountryFilterInterface|MockObject
     */
    protected CheckoutDataGiftCartPaymentCountryFilterInterface|MockObject $checkoutDataGiftCartPaymentCountryFilterMock;

    /**
     * @var CheckoutDataGiftCartPaymentCountryFilterFacadeInterface
     */
    protected CheckoutDataGiftCartPaymentCountryFilterFacadeInterface $checkoutDataGiftCartPaymentCountryFilterFacade;

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

        $this->checkoutDataGiftCartPaymentCountryFilterBusinessFactoryMock = $this
            ->getMockBuilder(CheckoutDataGiftCartPaymentCountryFilterBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutDataGiftCartPaymentCountryFilterMock = $this
            ->getMockBuilder(CheckoutDataGiftCartPaymentCountryFilter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutDataGiftCartPaymentCountryFilterFacade = new CheckoutDataGiftCartPaymentCountryFilterFacade();
        $this->checkoutDataGiftCartPaymentCountryFilterFacade->setFactory($this->checkoutDataGiftCartPaymentCountryFilterBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testFilter(): void
    {
        $this->checkoutDataGiftCartPaymentCountryFilterBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createCheckoutDataGiftCartPaymentCountryFilter')
            ->willReturn($this->checkoutDataGiftCartPaymentCountryFilterMock);

        $this->checkoutDataGiftCartPaymentCountryFilterMock->expects(static::atLeastOnce())
            ->method('filter')
            ->with($this->restCheckoutDataTransferMock, $this->restCheckoutRequestAttributesTransferMock)
            ->willReturn($this->restCheckoutDataTransferMock);

        $restCheckoutDataTransfer = $this->checkoutDataGiftCartPaymentCountryFilterFacade->filter(
            $this->restCheckoutDataTransferMock,
            $this->restCheckoutRequestAttributesTransferMock
        );

        static::assertEquals($restCheckoutDataTransfer, $this->restCheckoutDataTransferMock);
    }
}
