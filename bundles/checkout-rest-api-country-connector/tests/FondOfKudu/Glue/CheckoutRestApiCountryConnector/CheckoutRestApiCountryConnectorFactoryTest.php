<?php

namespace FondOfKudu\Glue\CheckoutRestApiCountryConnector;

use Codeception\Test\Unit;
use FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToGlossaryStorageClientBridge;
use FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToLocaleClientBridge;
use Spryker\Glue\Kernel\Container;

class CheckoutRestApiCountryConnectorFactoryTest extends Unit
{
    /**
     * @var \Spryker\Glue\Kernel\Container|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $containerMock;

    /**
     * @var \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToGlossaryStorageClientBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $glossaryStorageClientMock;

    /**
     * @var \FondOfKudu\Glue\CheckoutRestApiCountryConnector\Dependency\Client\CheckoutRestApiCountryConnectorToLocaleClientBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $localeClientMock;

    /**
     * @var \FondOfKudu\Glue\CheckoutRestApiCountryConnector\CheckoutRestApiCountryConnectorFactory
     */
    protected $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->glossaryStorageClientMock = $this->getMockBuilder(CheckoutRestApiCountryConnectorToGlossaryStorageClientBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeClientMock = $this->getMockBuilder(CheckoutRestApiCountryConnectorToLocaleClientBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new CheckoutRestApiCountryConnectorFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCountryMapper(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnOnConsecutiveCalls(
                $this->glossaryStorageClientMock,
                $this->localeClientMock,
            );

        $this->factory->createCountryMapper();
    }
}
