<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Plugin;

use FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorConfig;
use Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorFactory getFactory()
 * @method \FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorConfig getConfig()
 */
class CustomerRestorePasswordResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection): ResourceRouteCollectionInterface
    {
        $resourceRouteCollection->addPatch('patch', false);

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
        return $this->getConfig()->getResourceCustomerRestorePassword();
    }

    /**
     * @api
     *
     * @return string
     */
    public function getController(): string
    {
        return CustomersRestApiConnectorConfig::CONTROLLER_CUSTOMER_RESTORE_PASSWORD;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestCustomerRestorePasswordAttributesTransfer::class;
    }
}
