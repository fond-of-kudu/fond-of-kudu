<?php

namespace FondOfKudu\Client\CustomerPasswordUpdatedAtConnector;

use Codeception\Test\Unit;
use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Dependency\Client\CustomerPasswordUpdatedAtConnectorToZedRequestClientBridge;
use FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Zed\CustomerPasswordUpdatedAtConnectorStubInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;
use Spryker\Client\ZedRequest\ZedRequestClient;

class CustomerPasswordUpdatedAtConnectorFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\Dependency\Client\CustomerPasswordUpdatedAtConnectorToZedRequestClientBridge
     */
    protected MockObject|ZedRequestClient $zedRequestClientMock;

    /**
     * @var \FondOfKudu\Client\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorFactory
     */
    protected CustomerPasswordUpdatedAtConnectorFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->createMock(Container::class);
        $this->zedRequestClientMock = $this->createMock(CustomerPasswordUpdatedAtConnectorToZedRequestClientBridge::class);
        $this->factory = new CustomerPasswordUpdatedAtConnectorFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateZedCustomerStub(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn($this->zedRequestClientMock);

        static::assertInstanceOf(
            CustomerPasswordUpdatedAtConnectorStubInterface::class,
            $this->factory->createZedCustomerStub(),
        );
    }
}
