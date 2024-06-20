<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Plugin;

use FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorConfig;
use Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorFactory getFactory()
 * @method \FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorConfig getConfig()
 */
class CustomerPasswordUpdatedResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection): ResourceRouteCollectionInterface
    {
        $resourceRouteCollection->addPost('post', false);

        return $resourceRouteCollection;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getResourceType(): string
    {
        return CustomersRestApiConnectorConfig::RESOURCE_CUSTOMER_PASSWORD_UPDATED;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getController(): string
    {
        return CustomersRestApiConnectorConfig::CONTROLLER_CUSTOMER_PASSWORD_UPDATED;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestCustomerPasswordUpdatedAttributesTransfer::class;
    }
}
