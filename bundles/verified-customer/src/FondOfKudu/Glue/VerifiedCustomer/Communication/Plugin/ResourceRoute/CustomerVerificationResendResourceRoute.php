<?php

namespace FondOfKudu\Glue\VerifiedCustomer\Communication\Plugin\ResourceRoute;

use FondOfKudu\Glue\VerifiedCustomer\VerifiedCustomerConfig;
use Generated\Shared\Transfer\RestCustomerVerificationResendAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfKudu\Zed\VerifiedCustomer\VerifiedCustomerConfig getConfig()
 */
class CustomerVerificationResendResourceRoute extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection): ResourceRouteCollectionInterface
    {
        $resourceRouteCollection->addPost('post', true);

        return $resourceRouteCollection;
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return VerifiedCustomerConfig::RESOURCE_CUSTOMER_VERIFICATION_RESEND;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return VerifiedCustomerConfig::CONTROLLER_CUSTOMER_VERIFICATION_RESEND;
    }

    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestCustomerVerificationResendAttributesTransfer::class;
    }
}
