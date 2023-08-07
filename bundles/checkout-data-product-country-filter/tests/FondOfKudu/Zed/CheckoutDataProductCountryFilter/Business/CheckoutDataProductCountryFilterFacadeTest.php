<?php

namespace FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\Filter\CheckoutDataProductCountryFilter;
use FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\Filter\CheckoutDataProductCountryFilterInterface;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CheckoutDataProductCountryFilterFacadeTest extends Unit
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
     * @var \FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\CheckoutDataProductCountryFilterBusinessFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CheckoutDataProductCountryFilterBusinessFactory|MockObject $checkoutDataProductCountryFilterBusinessFactoryMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\Filter\CheckoutDataProductCountryFilterInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CheckoutDataProductCountryFilterInterface|MockObject $checkoutDataProductCountryFilterMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutDataProductCountryFilter\Business\CheckoutDataProductCountryFilterFacadeInterface
     */
    protected CheckoutDataProductCountryFilterFacadeInterface $checkoutDataProductCountryFilterFacade;

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

        $this->checkoutDataProductCountryFilterBusinessFactoryMock = $this
            ->getMockBuilder(CheckoutDataProductCountryFilterBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutDataProductCountryFilterMock = $this
            ->getMockBuilder(CheckoutDataProductCountryFilter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutDataProductCountryFilterFacade = new CheckoutDataProductCountryFilterFacade();
        $this->checkoutDataProductCountryFilterFacade->setFactory($this->checkoutDataProductCountryFilterBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testFilter(): void
    {
        $this->checkoutDataProductCountryFilterBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createCheckoutDataProductCountryFilter')
            ->willReturn($this->checkoutDataProductCountryFilterMock);

        $this->checkoutDataProductCountryFilterMock->expects(static::atLeastOnce())
            ->method('filter')
            ->with($this->restCheckoutDataTransferMock, $this->restCheckoutRequestAttributesTransferMock)
            ->willReturn($this->restCheckoutDataTransferMock);

        $restCheckoutDataTransfer = $this->checkoutDataProductCountryFilterFacade->filter(
            $this->restCheckoutDataTransferMock,
            $this->restCheckoutRequestAttributesTransferMock,
        );

        static::assertEquals($restCheckoutDataTransfer, $this->restCheckoutDataTransferMock);
    }
}
