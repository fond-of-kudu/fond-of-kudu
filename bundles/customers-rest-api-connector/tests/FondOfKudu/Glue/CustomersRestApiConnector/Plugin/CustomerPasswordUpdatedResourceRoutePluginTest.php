<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Plugin;

use Codeception\Test\Unit;
use FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorConfig;
use Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\Collection\ResourceRouteCollection;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class CustomerPasswordUpdatedResourceRoutePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected MockObject|ResourceRouteCollectionInterface $resourceRouteCollectionMock;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Plugin\CustomerPasswordUpdatedResourceRoutePlugin
     */
    protected CustomerPasswordUpdatedResourceRoutePlugin $customerPasswordUpdatedResourceRoutePlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resourceRouteCollectionMock = $this->createMock(ResourceRouteCollection::class);
        $this->customerPasswordUpdatedResourceRoutePlugin = new CustomerPasswordUpdatedResourceRoutePlugin();
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionMock->expects(static::once())
            ->method('addPost')
            ->with('post', false)
            ->willReturnSelf();

        static::assertEquals(
            $this->customerPasswordUpdatedResourceRoutePlugin->configure($this->resourceRouteCollectionMock),
            $this->resourceRouteCollectionMock,
        );
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        static::assertEquals(
            $this->customerPasswordUpdatedResourceRoutePlugin->getResourceType(),
            CustomersRestApiConnectorConfig::RESOURCE_CUSTOMER_PASSWORD_UPDATED,
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        static::assertEquals(
            $this->customerPasswordUpdatedResourceRoutePlugin->getController(),
            CustomersRestApiConnectorConfig::CONTROLLER_CUSTOMER_PASSWORD_UPDATED,
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        static::assertEquals(
            $this->customerPasswordUpdatedResourceRoutePlugin->getResourceAttributesClassName(),
            RestCustomerPasswordUpdatedAttributesTransfer::class,
        );
    }
}
