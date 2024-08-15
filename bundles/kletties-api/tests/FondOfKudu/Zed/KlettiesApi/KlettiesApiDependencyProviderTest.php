<?php

namespace FondOfKudu\Zed\KlettiesApi;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class KlettiesApiDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\KlettiesApiDependencyProvider
     */
    protected $klettiesApiDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->klettiesApiDependencyProvider = new KlettiesApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        static::assertInstanceOf(
            Container::class,
            $this->klettiesApiDependencyProvider->provideBusinessLayerDependencies(
                $this->containerMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testProvidePersistenceLayerDependencies(): void
    {
        static::assertInstanceOf(
            Container::class,
            $this->klettiesApiDependencyProvider->providePersistenceLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
