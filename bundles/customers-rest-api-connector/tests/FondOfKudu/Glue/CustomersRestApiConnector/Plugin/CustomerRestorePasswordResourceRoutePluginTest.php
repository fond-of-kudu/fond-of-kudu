<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Plugin;

use Codeception\Test\Unit;
use FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorConfig;
use Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\GlueApplication\Rest\Collection\ResourceRouteCollection;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class CustomerRestorePasswordResourceRoutePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected MockObject|ResourceRouteCollectionInterface $resourceRouteCollectionMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorConfig
     */
    protected MockObject|CustomersRestApiConnectorConfig $configMock;

    /**
     * @var \FondOfKudu\Glue\CustomersRestApiConnector\Plugin\CustomerRestorePasswordResourceRoutePlugin
     */
    protected CustomerRestorePasswordResourceRoutePlugin $customerRestorePasswordResourceRoutePlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resourceRouteCollectionMock = $this->createMock(ResourceRouteCollection::class);
        $this->configMock = $this->createMock(CustomersRestApiConnectorConfig::class);
        $this->customerRestorePasswordResourceRoutePlugin = new CustomerRestorePasswordResourceRoutePlugin();
        $this->customerRestorePasswordResourceRoutePlugin->setConfig($this->configMock);
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionMock->expects(static::once())
            ->method('addPatch')
            ->with('patch', false)
            ->willReturnSelf();

        static::assertEquals(
            $this->customerRestorePasswordResourceRoutePlugin->configure($this->resourceRouteCollectionMock),
            $this->resourceRouteCollectionMock,
        );
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        $this->configMock->expects(static::once())
            ->method('getResourceCustomerRestorePassword')
            ->willReturn(CustomersRestApiConnectorConfig::RESOURCE_CUSTOMER_RESTORE_PASSWORD);

        static::assertEquals(
            $this->customerRestorePasswordResourceRoutePlugin->getResourceType(),
            CustomersRestApiConnectorConfig::RESOURCE_CUSTOMER_RESTORE_PASSWORD,
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        static::assertEquals(
            $this->customerRestorePasswordResourceRoutePlugin->getController(),
            CustomersRestApiConnectorConfig::CONTROLLER_CUSTOMER_RESTORE_PASSWORD,
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        static::assertEquals(
            $this->customerRestorePasswordResourceRoutePlugin->getResourceAttributesClassName(),
            RestCustomerRestorePasswordAttributesTransfer::class,
        );
    }
}
