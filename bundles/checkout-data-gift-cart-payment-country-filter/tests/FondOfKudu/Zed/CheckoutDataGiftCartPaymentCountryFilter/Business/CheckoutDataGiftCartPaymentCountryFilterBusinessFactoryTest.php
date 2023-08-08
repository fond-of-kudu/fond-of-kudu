<?php

namespace FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\Business\Filter\CheckoutDataGiftCartPaymentCountryFilter;
use FondOfKudu\Zed\CheckoutDataGiftCartPaymentCountryFilter\CheckoutDataGiftCartPaymentCountryFilterConfig;
use PHPUnit\Framework\MockObject\MockObject;

class CheckoutDataGiftCartPaymentCountryFilterBusinessFactoryTest extends Unit
{
    /**
     * @var CheckoutDataGiftCartPaymentCountryFilterBusinessFactory
     */
    protected CheckoutDataGiftCartPaymentCountryFilterBusinessFactory $checkoutDataGiftCartPaymentCountryFilterBusinessFactory;

    /**
     * @var CheckoutDataGiftCartPaymentCountryFilterConfig|MockObject
     */
    protected CheckoutDataGiftCartPaymentCountryFilterConfig|MockObject $checkoutDataGiftCartPaymentCountryFilterConfigMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->checkoutDataGiftCartPaymentCountryFilterConfigMock = $this
            ->getMockBuilder(CheckoutDataGiftCartPaymentCountryFilterConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->checkoutDataGiftCartPaymentCountryFilterBusinessFactory = new CheckoutDataGiftCartPaymentCountryFilterBusinessFactory();
        $this->checkoutDataGiftCartPaymentCountryFilterBusinessFactory->setConfig($this->checkoutDataGiftCartPaymentCountryFilterConfigMock);
    }

    /**
     * @return void
     */
    public function testCreateCheckoutDataGiftCartPaymentCountryFilter(): void
    {
        $checkoutDataGiftCartPaymentCountryFilter = $this->checkoutDataGiftCartPaymentCountryFilterBusinessFactory->createCheckoutDataGiftCartPaymentCountryFilter();

        static::assertInstanceOf(CheckoutDataGiftCartPaymentCountryFilter::class, $checkoutDataGiftCartPaymentCountryFilter);
    }
}
