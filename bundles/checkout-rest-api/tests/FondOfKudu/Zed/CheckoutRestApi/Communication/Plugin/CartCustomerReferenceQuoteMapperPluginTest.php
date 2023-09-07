<?php

namespace FondOfKudu\Zed\CheckoutRestApi\Communication\Plugin;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CartCustomerReferenceQuoteMapperPluginTest extends Unit
{
    /**
     * @var (\Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\QuoteTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var (\Generated\Shared\Transfer\CustomerTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerTransfer|MockObject $customerTransferMock;

    /**
     * @var string
     */
    protected string $customerReference;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restCheckoutRequestAttributesTransferMock = $this->getMockBuilder(RestCheckoutRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReference = 'customer-reference';

        $this->cartCustomerReferenceQuoteMapperPlugin = new CartCustomerReferenceQuoteMapperPlugin();
    }

    /**
     * @return void
     */
    public function testMap(): void
    {
        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getCustomerReference')
            ->willReturn($this->customerReference);

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('setCartCustomerReference')
            ->with($this->customerReference)
            ->willReturnSelf();

        $this->cartCustomerReferenceQuoteMapperPlugin->map($this->restCheckoutRequestAttributesTransferMock, $this->quoteTransferMock);
    }
}
