<?php

namespace FondOfKudu\Zed\KlettiesApi\Persistence;

use Codeception\Test\Unit;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeBridge;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeBridge;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface;
use FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerBridge;
use FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerInterface;
use FondOfKudu\Zed\KlettiesApi\KlettiesApiDependencyProvider;
use FondOfKudu\Zed\KlettiesApi\Persistence\Propel\Mapper\TransferMapperInterface;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery;
use Spryker\Zed\Kernel\Container;

class KlettiesApiPersistenceFactoryTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiPersistenceFactory
     */
    protected $factory;

    /**
     * @var \Spryker\Zed\Kernel\Container|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $containerMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesQueryContainerMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\QueryContainer\KlettiesApiToApiQueryBuilderContainerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesQueryBuilderContainerMock;

    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesFacadeMock;

    /**
     * @var \Orm\Zed\Kletties\Persistence\FokKlettiesOrderQuery|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $orderQueryMock;

    /**
     * @return void
     */
    public function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)->disableOriginalConstructor()->getMock();
        $this->klettiesFacadeMock = $this->getMockBuilder(KlettiesApiToKlettiesFacadeBridge::class)->disableOriginalConstructor()->getMock();
        $this->klettiesQueryContainerMock = $this->getMockBuilder(KlettiesApiToApiFacadeBridge::class)->disableOriginalConstructor()->getMock();
        $this->klettiesQueryBuilderContainerMock = $this->getMockBuilder(KlettiesApiToApiQueryBuilderContainerBridge::class)->disableOriginalConstructor()->getMock();
        $this->orderQueryMock = $this->getMockBuilder(FokKlettiesOrderQuery::class)->disableOriginalConstructor()->getMock();

        $this->factory = new KlettiesApiPersistenceFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateTransferMapper(): void
    {
        $this->assertInstanceOf(
            TransferMapperInterface::class,
            $this->factory->createTransferMapper(),
        );
    }

    /**
     * @return void
     */
    public function testGetKlettiesOrderQuery(): void
    {
        $this->containerMock->method('has')->willReturn(true);
        $this->containerMock->method('get')->with(KlettiesApiDependencyProvider::QUERY_KLETTIES_ORDER)->willReturn($this->orderQueryMock);

        $this->assertInstanceOf(FokKlettiesOrderQuery::class, $this->factory->getKlettiesOrderQuery());
    }

    /**
     * @return void
     */
    public function testGetQueryBuilderContainer(): void
    {
        $this->containerMock->method('has')->willReturn(true);
        $this->containerMock->method('get')->with(KlettiesApiDependencyProvider::QUERY_BUILDER_CONTAINER_API)->willReturn($this->klettiesQueryBuilderContainerMock);

        $this->assertInstanceOf(KlettiesApiToApiQueryBuilderContainerInterface::class, $this->factory->getQueryBuilderContainer());
    }

    /**
     * @return void
     */
    public function testGetQueryContainer(): void
    {
        $this->containerMock->method('has')->willReturn(true);
        $this->containerMock->method('get')->with(KlettiesApiDependencyProvider::FACADE_API)->willReturn($this->klettiesQueryContainerMock);

        $this->assertInstanceOf(KlettiesApiToApiFacadeInterface::class, $this->factory->getQueryContainer());
    }

    /**
     * @return void
     */
    public function testGetKlettiesFacade(): void
    {
        $this->containerMock->method('has')->willReturn(true);
        $this->containerMock->method('get')->with(KlettiesApiDependencyProvider::FACADE_KLETTIES)->willReturn($this->klettiesFacadeMock);

        $this->assertInstanceOf(KlettiesApiToKlettiesFacadeInterface::class, $this->factory->getKlettiesFacade());
    }
}
