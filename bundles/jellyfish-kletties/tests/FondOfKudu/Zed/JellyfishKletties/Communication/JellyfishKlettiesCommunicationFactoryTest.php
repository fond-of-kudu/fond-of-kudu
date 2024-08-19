<?php

namespace FondOfKudu\Zed\JellyfishKletties\Communication;

use Codeception\Test\Unit;
use FondOfKudu\Zed\JellyfishKletties\Dependency\Facade\JellyfishKlettiesToKlettiesFacadeBridge;
use FondOfKudu\Zed\JellyfishKletties\Dependency\Facade\JellyfishKlettiesToKlettiesFacadeInterface;
use FondOfKudu\Zed\JellyfishKletties\JellyfishKlettiesDependencyProvider;
use Spryker\Zed\Kernel\Container;

class JellyfishKlettiesCommunicationFactoryTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\JellyfishKletties\Communication\JellyfishKlettiesCommunicationFactory
     */
    protected $factory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \FondOfKudu\Zed\JellyfishKletties\Dependency\Facade\JellyfishKlettiesToKlettiesFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $facadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->facadeMock = $this->getMockBuilder(JellyfishKlettiesToKlettiesFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new JellyfishKlettiesCommunicationFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetKlettiesFacade(): void
    {
        $this->containerMock->expects($this->once())->method('has')->willReturn(true);
        $this->containerMock
            ->expects($this->once())
            ->method('get')
            ->with(JellyfishKlettiesDependencyProvider::FACADE_KLETTIES)
            ->willReturn($this->facadeMock);

        $this->assertInstanceOf(JellyfishKlettiesToKlettiesFacadeInterface::class, $this->factory->getKlettiesFacade());
    }
}
