<?php

namespace FondOfKudu\Zed\CustomerPasswordChangedAtConnector\Dependency\QueryContainer;

use Codeception\Test\Unit;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerBridge;
use FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Customer\Persistence\CustomerQueryContainerInterface;

class CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Customer\Persistence\CustomerQueryContainerInterface
     */
    protected MockObject|CustomerQueryContainerInterface $customerQueryContainerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    protected MockObject|SpyCustomerQuery $spyCustomerQueryMock;

    /**
     * @var \FondOfKudu\Zed\CustomerPasswordUpdatedAtConnector\Dependency\QueryContainer\CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface
     */
    protected CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerInterface $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerQueryContainerMock = $this->createMock(CustomerQueryContainerInterface::class);
        $this->spyCustomerQueryMock = $this->createMock(SpyCustomerQuery::class);
        $this->bridge = new CustomerPasswordUpdatedAtConnectorToCustomerQueryContainerBridge($this->customerQueryContainerMock);
    }

    /**
     * @return void
     */
    public function testQueryCustomerById(): void
    {
        $this->customerQueryContainerMock->expects(static::once())
            ->method('queryCustomerById')
            ->with(11)
            ->willReturn($this->spyCustomerQueryMock);

        static::assertEquals($this->bridge->queryCustomerById(11), $this->spyCustomerQueryMock);
    }

    /**
     * @return void
     */
    public function testQueryCustomerByEmail(): void
    {
        $this->customerQueryContainerMock->expects(static::once())
            ->method('queryCustomerByEmail')
            ->with('foobar@mailinator.com')
            ->willReturn($this->spyCustomerQueryMock);

        static::assertEquals(
            $this->bridge->queryCustomerByEmail('foobar@mailinator.com'),
            $this->spyCustomerQueryMock,
        );
    }

    /**
     * @return void
     */
    public function testQueryCustomerByRestorePasswordKey(): void
    {
        $this->customerQueryContainerMock->expects(static::once())
            ->method('queryCustomerByRestorePasswordKey')
            ->with('token')
            ->willReturn($this->spyCustomerQueryMock);

        static::assertEquals(
            $this->bridge->queryCustomerByRestorePasswordKey('token'),
            $this->spyCustomerQueryMock,
        );
    }
}
