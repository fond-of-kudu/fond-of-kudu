<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\DiscountTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class DiscountCalculationRequestMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\DiscountTransfer
     */
    protected MockObject|DiscountTransfer $discountTransferMock;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\DiscountCalculationRequestMapperInterface
     */
    protected DiscountCalculationRequestMapperInterface $discountCalculationRequestMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->discountTransferMock = $this->getMockBuilder(DiscountTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->discountCalculationRequestMapper = new DiscountCalculationRequestMapper();
    }

    /**
     * @return void
     */
    public function testMapFromDiscountTransfer(): void
    {
        $discountCalculationRequestTransfer = $this->discountCalculationRequestMapper->mapFromDiscountTransfer(
            $this->discountTransferMock,
            2000,
        );

        static::assertEquals($discountCalculationRequestTransfer->getDiscount(), $this->discountTransferMock);
        static::assertEquals($discountCalculationRequestTransfer->getDiscountableItems()[0]->getUnitPrice(), 2000);
    }
}
