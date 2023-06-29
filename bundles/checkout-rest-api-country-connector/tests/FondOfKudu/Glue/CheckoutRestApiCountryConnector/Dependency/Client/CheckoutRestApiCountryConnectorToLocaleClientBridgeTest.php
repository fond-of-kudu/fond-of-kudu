<?php

namespace FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client;

use Codeception\Test\Unit;
use Spryker\Client\Locale\LocaleClient;

class CheckoutRestApiCountryConnectorToLocaleClientBridgeTest extends Unit
{
    /**
     * @var \Spryker\Client\Locale\LocaleClient|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $localeClientMock;

    /**
     * @var \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToLocaleClientBridge
     */
    protected $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->localeClientMock = $this->getMockBuilder(LocaleClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CheckoutRestApiCountryConnectorToLocaleClientBridge($this->localeClientMock);
    }

    /**
     * @return void
     */
    public function testGetCurrentLocale(): void
    {
        $this->localeClientMock->expects(static::atLeastOnce())
            ->method('getCurrentLocale')
            ->willReturn('de_DE');

        static::assertEquals('de_DE', $this->bridge->getCurrentLocale());
    }
}
