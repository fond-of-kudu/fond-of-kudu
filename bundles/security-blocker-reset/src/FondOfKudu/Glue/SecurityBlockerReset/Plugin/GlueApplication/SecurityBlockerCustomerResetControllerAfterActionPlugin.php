<?php

namespace FondOfKudu\Glue\SecurityBlockerReset\Plugin\GlueApplication;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ControllerAfterActionPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfKudu\Glue\SecurityBlockerReset\SecurityBlockerResetFactory getFactory()
 */
class SecurityBlockerCustomerResetControllerAfterActionPlugin extends AbstractPlugin implements ControllerAfterActionPluginInterface
{
    /**
     * @param string $action
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return void
     */
    public function afterAction(string $action, RestRequestInterface $restRequest, RestResponseInterface $restResponse): void
    {
        $this->getFactory()
            ->createSecurityBlockerStorage()
            ->resetIsBlocked($action, $restRequest, $restResponse);
    }
}
