<?php

namespace FondOfKudu\Zed\KlettiesApi\Business;

use Codeception\Test\Unit;
use Exception;
use FondOfKudu\Zed\KlettiesApi\Business\Model\KlettiesOrderApiInterface;
use FondOfKudu\Zed\KlettiesApi\Business\Model\Validator\KlettiesApiValidatorInterface;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToApiFacadeBridge;
use FondOfKudu\Zed\KlettiesApi\Dependency\Facade\KlettiesApiToKlettiesFacadeBridge;
use FondOfKudu\Zed\KlettiesApi\KlettiesApiDependencyProvider;
use FondOfKudu\Zed\KlettiesApi\Persistence\KlettiesApiRepository;
use Spryker\Zed\Kernel\Container;

class KlettiesApiBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\KlettiesApi\Business\KlettiesApiBusinessFactory
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
     * @var \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $klettiesFacadeMock;

    /**
     * @var \Spryker\Zed\Kernel\Persistence\AbstractRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $repositoryMock;

    /**
     * @return void
     */
    public function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)->disableOriginalConstructor()->getMock();
        $this->klettiesFacadeMock = $this->getMockBuilder(KlettiesApiToKlettiesFacadeBridge::class)->disableOriginalConstructor()->getMock();
        $this->klettiesQueryContainerMock = $this->getMockBuilder(KlettiesApiToApiFacadeBridge::class)->disableOriginalConstructor()->getMock();
        $this->repositoryMock = $this->getMockBuilder(KlettiesApiRepository::class)->disableOriginalConstructor()->getMock();

        $this->factory = new KlettiesApiBusinessFactory();
        $this->factory->setContainer($this->containerMock);
        $this->factory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateKlettiesApi(): void
    {
        $self = $this;
        $this->containerMock->method('has')->willReturn(true);
        $this->containerMock->method('get')->willReturnCallback(static function ($key) use ($self) {
            if ($key === KlettiesApiDependencyProvider::FACADE_API) {
                return $self->klettiesQueryContainerMock;
            }
            if ($key === KlettiesApiDependencyProvider::FACADE_KLETTIES) {
                return $self->klettiesFacadeMock;
            }

            throw new Exception('error');
        });

        $this->assertInstanceOf(KlettiesOrderApiInterface::class, $this->factory->createKlettiesApi());
    }

    /**
     * @return void
     */
    public function testCreateKlettiesApiValidator(): void
    {
        $this->assertInstanceOf(
            KlettiesApiValidatorInterface::class,
            $this->factory->createKlettiesApiValidator(),
        );
    }
}
