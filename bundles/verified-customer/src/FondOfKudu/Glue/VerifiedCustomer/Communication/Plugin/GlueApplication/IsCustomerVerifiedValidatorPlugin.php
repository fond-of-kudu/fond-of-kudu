<?php

namespace FondOfKudu\Glue\VerifiedCustomer\Communication\Plugin\GlueApplication;

use Generated\Shared\Transfer\RestErrorCollectionTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RestRequestValidatorPluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \FondOfKudu\Glue\VerifiedCustomer\VerifiedCustomerFactory getFactory()
 */
class IsCustomerVerifiedValidatorPlugin extends AbstractPlugin implements RestRequestValidatorPluginInterface
{
 /**
  * @param \Symfony\Component\HttpFoundation\Request $httpRequest
  * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
  *
  * @return \Generated\Shared\Transfer\RestErrorCollectionTransfer|null
  */
    public function validate(Request $httpRequest, RestRequestInterface $restRequest): ?RestErrorCollectionTransfer
    {
        return $this->getFactory()->createVerifiedCustomerValidator()->isVerified($restRequest);
    }
}
