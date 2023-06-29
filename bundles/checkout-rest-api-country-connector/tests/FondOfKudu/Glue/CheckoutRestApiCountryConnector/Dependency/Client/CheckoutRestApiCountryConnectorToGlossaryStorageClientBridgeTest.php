<?php

namespace FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client;

use Codeception\Test\Unit;
use Spryker\Client\GlossaryStorage\GlossaryStorageClient;

class CheckoutRestApiCountryConnectorToGlossaryStorageClientBridgeTest extends Unit
{
    /**
     * @var \Spryker\Client\GlossaryStorage\GlossaryStorageClient|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $glossaryStorageClientMock;

    /**
     * @var \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToGlossaryStorageClientBridge
     */
    protected $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->glossaryStorageClientMock = $this->getMockBuilder(GlossaryStorageClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CheckoutRestApiCountryConnectorToGlossaryStorageClientBridge($this->glossaryStorageClientMock);
    }

    /**
     * @return void
     */
    public function testTranslate(): void
    {
        $this->glossaryStorageClientMock->expects(static::atLeastOnce())
            ->method('translate')
            ->with('translation.key', 'de_de')
            ->willReturn('FooBar');

        static::assertEquals('FooBar', $this->bridge->translate('translation.key', 'de_de'));
    }
}
