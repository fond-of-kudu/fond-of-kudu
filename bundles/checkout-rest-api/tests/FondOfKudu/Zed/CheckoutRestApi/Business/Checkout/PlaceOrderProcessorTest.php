<?php

namespace FondOfKudu\Zed\CheckoutRestApi\Business\Checkout;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToQuoteFacadeInterface;
use Generated\Shared\Transfer\CheckoutDataTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCheckoutResponseTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\CheckoutRestApi\Business\Validator\CheckoutValidatorInterface;
use Spryker\Zed\CheckoutRestApi\CheckoutRestApiConfig as ZedCheckoutRestApiConfig;
use Spryker\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToCalculationFacadeInterface;
use Spryker\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToCheckoutFacadeInterface;

class PlaceOrderProcessorTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\CheckoutRestApi\Business\Checkout\PlaceOrderProcessor
     */
    protected PlaceOrderProcessor $placeOrderProcessor;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToCheckoutFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|CheckoutRestApiToCheckoutFacadeInterface $checkoutFacadeMock;

    /**
     * @var (\FondOfKudu\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToQuoteFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CheckoutRestApiToQuoteFacadeInterface|MockObject $quoteFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\CheckoutRestApi\Dependency\Facade\CheckoutRestApiToCalculationFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected CheckoutRestApiToCalculationFacadeInterface|MockObject $calculationFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\CheckoutRestApi\Business\Validator\CheckoutValidatorInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|CheckoutValidatorInterface $validatorFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\CheckoutRestApi\CheckoutRestApiConfig&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|ZedCheckoutRestApiConfig $configMock;

    /**
     * @var (\Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\RestCheckoutResponseTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|RestCheckoutResponseTransfer $restCheckoutResponseTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CheckoutDataTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CheckoutDataTransfer $checkoutDataTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CheckoutResponseTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CheckoutResponseTransfer|MockObject $checkoutResponseTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\SaveOrderTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|SaveOrderTransfer $saveOrderTransferMock;

    /**
     * @var string
     */
    protected string $orderReference;

    /**
     * @var string
     */
    protected string $redirectUrl;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->checkoutFacadeMock = $this->getMockBuilder(CheckoutRestApiToCheckoutFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteFacadeMock = $this->getMockBuilder(CheckoutRestApiToQuoteFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->calculationFacadeMock = $this->getMockBuilder(CheckoutRestApiToCalculationFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->validatorFacadeMock = $this->getMockBuilder(CheckoutValidatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(ZedCheckoutRestApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutRequestAttributesTransferMock = $this->getMockBuilder(RestCheckoutRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutResponseTransferMock = $this->getMockBuilder(RestCheckoutResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutDataTransferMock = $this->getMockBuilder(CheckoutDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutResponseTransferMock = $this->getMockBuilder(CheckoutResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->saveOrderTransferMock = $this->getMockBuilder(SaveOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderReference = 'order-reference';

        $this->redirectUrl = 'redirect-url';

        $this->placeOrderProcessor = new PlaceOrderProcessor(
            $this->checkoutFacadeMock,
            $this->quoteFacadeMock,
            $this->calculationFacadeMock,
            $this->validatorFacadeMock,
            [],
            $this->configMock,
        );
    }

    /**
     * @return void
     */
    public function testPlaceOrder(): void
    {
        $this->validatorFacadeMock->expects($this->atLeastOnce())
            ->method('validateCheckout')
            ->with($this->restCheckoutRequestAttributesTransferMock)
        ->willReturn($this->restCheckoutResponseTransferMock);

        $this->restCheckoutResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->restCheckoutResponseTransferMock->expects($this->atLeastOnce())
            ->method('getCheckoutData')
            ->willReturn($this->checkoutDataTransferMock);

        $this->checkoutDataTransferMock->expects($this->atLeastOnce())
            ->method('getQuote')
            ->willReturn($this->quoteTransferMock);

        $this->calculationFacadeMock->expects($this->atLeastOnce())
            ->method('recalculateQuote')
            ->with($this->quoteTransferMock)
            ->willReturn($this->quoteTransferMock);

        $this->checkoutFacadeMock->expects($this->atLeastOnce())
            ->method('placeOrder')
            ->with($this->quoteTransferMock)
            ->willReturn($this->checkoutResponseTransferMock);

        $this->checkoutResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccess')
            ->willReturn(true);

        $this->configMock->expects($this->atLeastOnce())
            ->method('deleteCartAfterOrderCreation')
            ->willReturn(false);

        $this->checkoutResponseTransferMock->expects($this->atLeastOnce())
            ->method('getRedirectUrl')
            ->willReturn($this->redirectUrl);

        $this->checkoutResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsExternalRedirect')
            ->willReturn(true);

        $this->checkoutResponseTransferMock->expects($this->atLeastOnce())
            ->method('getSaveOrder')
            ->willReturn($this->saveOrderTransferMock);

        $this->saveOrderTransferMock->expects($this->atLeastOnce())
            ->method('getOrderReference')
            ->willReturn($this->orderReference);

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('setOrderReference')
            ->with($this->orderReference);

        $this->quoteFacadeMock->expects($this->atLeastOnce())
            ->method('updateQuote')
            ->with($this->quoteTransferMock);

        $restCheckoutResponseTransfer = $this->placeOrderProcessor->placeOrder($this->restCheckoutRequestAttributesTransferMock);

        $this->assertTrue($restCheckoutResponseTransfer->getIsSuccess());
        $this->assertSame($this->redirectUrl, $restCheckoutResponseTransfer->getRedirectUrl());
        $this->assertTrue($restCheckoutResponseTransfer->getIsExternalRedirect());
        $this->assertSame($this->orderReference, $restCheckoutResponseTransfer->getOrderReference());
        $this->assertSame($this->checkoutResponseTransferMock, $restCheckoutResponseTransfer->getCheckoutResponse());
    }
}
