<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Controller;

use Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorFactory getFactory()
 */
class CustomerPasswordUpdatedResourceController extends AbstractController
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCustomerPasswordUpdatedAttributesTransfer $restCustomerPasswordUpdatedAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function postAction(
        RestRequestInterface $restRequest,
        RestCustomerPasswordUpdatedAttributesTransfer $restCustomerPasswordUpdatedAttributesTransfer
    ): RestResponseInterface {
        return $this->getFactory()
            ->createCustomerPasswordUpdatedProcessor()
            ->passwordUpdated($restCustomerPasswordUpdatedAttributesTransfer);
    }
}
