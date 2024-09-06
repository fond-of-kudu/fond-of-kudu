<?php

namespace FondOfKudu\Glue\VerifiedCustomer\Communication\Plugin\GlueApplication;

use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RestUserValidatorPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfKudu\Glue\VerifiedCustomer\VerifiedCustomerFactory getFactory()
 * @method \FondOfKudu\Glue\VerifiedCustomer\VerifiedCustomerConfig getConfig()
 */
class IsCustomerVerifiedValidatorPlugin extends AbstractPlugin implements RestUserValidatorPluginInterface
{
 /**
  * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
  *
  * @return \Generated\Shared\Transfer\RestErrorMessageTransfer|null
  */
    public function validate(RestRequestInterface $restRequest): ?RestErrorMessageTransfer
    {
        return $this->getFactory()->createVerifiedCustomerValidator()->isVerified($restRequest);
    }
}
