<?php

namespace FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper;

use Codeception\Test\Unit;
use FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToCurrencyClientBridge;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RestProductPriceAttributeMapperTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\DiscountPromotionsRestApi\Dependency\Client\DiscountPromotionsRestApiToCurrencyClientBridge
     */
    protected MockObject|DiscountPromotionsRestApiToCurrencyClientBridge $currencyClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ProductViewTransfer
     */
    protected MockObject|ProductViewTransfer $productViewTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected MockObject|CurrencyTransfer $currencyTransferMock;

    /**
     * @var \FondOfKudu\Glue\DiscountPromotionsRestApi\Processor\Mapper\RestProductPriceAttributeMapperInterface
     */
    protected RestProductPriceAttributeMapperInterface $restProductPriceAttributeMapper;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_after();

        $this->currencyClientMock = $this->getMockBuilder(DiscountPromotionsRestApiToCurrencyClientBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productViewTransferMock = $this->getMockBuilder(ProductViewTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restProductPriceAttributeMapper = new RestProductPriceAttributeMapper($this->currencyClientMock);
    }

    /**
     * @return void
     */
    public function testMapFromProductViewTransfer(): void
    {
        $this->currencyClientMock->expects(static::atLeastOnce())
            ->method('getCurrent')
            ->willReturn($this->currencyTransferMock);

        $this->currencyTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([
                CurrencyTransfer::CODE => 'EUR',
                CurrencyTransfer::NAME => 'Euro',
                CurrencyTransfer::SYMBOL => '€',
            ]);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getPrice')
            ->willReturn(2000);

        $this->productViewTransferMock->expects(static::atLeastOnce())
            ->method('getPrices')
            ->willReturn(['ORIGINAL' => 2000]);

        $restProductPriceAttributesTransfer = $this->restProductPriceAttributeMapper->mapFromProductViewTransfer(
            $this->productViewTransferMock,
        );

        static::assertEquals($restProductPriceAttributesTransfer->getGrossAmount(), 2000);
        static::assertEquals($restProductPriceAttributesTransfer->getPriceTypeName(), 'ORIGINAL');
        static::assertEquals($restProductPriceAttributesTransfer->getCurrency()->getCode(), 'EUR');
        static::assertEquals($restProductPriceAttributesTransfer->getCurrency()->getName(), 'Euro');
        static::assertEquals($restProductPriceAttributesTransfer->getCurrency()->getSymbol(), '€');
    }
}
