<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\DiscountCalculationRequestTransfer;
use Generated\Shared\Transfer\DiscountCalculationResponseTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Service\Discount\DiscountService;

class DiscountPromotionsRestApiToDiscountServiceBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Service\Discount\DiscountService
     */
    protected MockObject|DiscountService $discountServiceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\DiscountCalculationRequestTransfer
     */
    protected MockObject|DiscountCalculationRequestTransfer $discountCalculationRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\DiscountCalculationResponseTransfer
     */
    protected MockObject|DiscountCalculationResponseTransfer $calculationResponseTransferMock;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Service\DiscountPromotionsRestApiToDiscountServiceInterface
     */
    protected DiscountPromotionsRestApiToDiscountServiceInterface $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->discountServiceMock = $this->getMockBuilder(DiscountService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->discountCalculationRequestTransferMock = $this->getMockBuilder(DiscountCalculationRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->calculationResponseTransferMock = $this->getMockBuilder(DiscountCalculationResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new DiscountPromotionsRestApiToDiscountServiceBridge($this->discountServiceMock);
    }

    /**
     * @return void
     */
    public function testCalculate(): void
    {
        $this->discountServiceMock->expects(static::atLeastOnce())
            ->method('calculate')
            ->with($this->discountCalculationRequestTransferMock)
            ->willReturn($this->calculationResponseTransferMock);

        $discountCalculationResponseTransfer = $this->bridge->calculate($this->discountCalculationRequestTransferMock);

        static::assertEquals($discountCalculationResponseTransfer, $this->calculationResponseTransferMock);
    }
}
