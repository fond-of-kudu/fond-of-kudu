<?php

namespace FondOfKudu\Zed\JellyfishKletties;

use Codeception\Test\Unit;
use FondOfKudu\Zed\Kletties\Business\KlettiesFacade;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Locator;

class JellyfishKlettiesDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\JellyfishKletties\JellyfishKlettiesDependencyProvider
     */
    protected $jellyfishKlettiesDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \Spryker\Zed\Kernel\Locator|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $locatorMock;

    /**
     * @var \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesFacade = $this->getMockBuilder(KlettiesFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->jellyfishKlettiesDependencyProvider = new JellyfishKlettiesDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideCommunicationLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->jellyfishKlettiesDependencyProvider->provideCommunicationLayerDependencies(
                $this->containerMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddKlettiesFacade(): void
    {
        $this->containerMock->method('getLocator')->willReturn($this->locatorMock);
        $this->jellyfishKlettiesDependencyProvider->addKlettiesFacade($this->containerMock);
    }
}
