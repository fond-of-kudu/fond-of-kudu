<?php

namespace FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeBridge;
use FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToStoreFacadeBridge;
use Spryker\Zed\Kernel\Container;

class CheckoutRestApiCountryConnectorBusinessFactoryTest extends Unit
{
    /**
     * @var \Spryker\Zed\Kernel\Container|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $containerMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToStoreFacadeBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeFacadeMock;

    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Business\CheckoutRestApiCountryConnectorBusinessFactory
     */
    protected $factory;

    /**
     * @var \FondOfKudu\Zed\CheckoutRestApiCountryConnector\Dependency\Facade\CheckoutRestApiCountryConnectorToCountryFacadeBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    private $countryFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeFacadeMock = $this->getMockBuilder(CheckoutRestApiCountryConnectorToStoreFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryFacadeMock = $this->getMockBuilder(CheckoutRestApiCountryConnectorToCountryFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new CheckoutRestApiCountryConnectorBusinessFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCheckoutDataExpander(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturnOnConsecutiveCalls(
                $this->storeFacadeMock,
                $this->countryFacadeMock,
                [],
            );

        $this->factory->createCheckoutDataExpander();
    }
}
