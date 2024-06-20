<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Controller;

use Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfKudu\Glue\CustomersRestApiConnector\CustomersRestApiConnectorFactory getFactory()
 */
class CustomerRestorePasswordResourceController extends AbstractController
{
    /**
     * @Glue({
     *     "patch": {
     *          "summary": [
     *              "Restores customer password."
     *          ],
     *           "parameters": [{
     *              "ref": "acceptLanguage"
     *          }],
     *          "responses": {
     *              "204": "No content.",
     *              "400": "Customer restore password id is not specified.",
     *              "422": "Restore password key is not valid."
     *          },
     *          "isEmptyResponse": true
     *     }
     * })
     *
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function patchAction(
        RestRequestInterface $restRequest,
        RestCustomerRestorePasswordAttributesTransfer $restCustomerRestorePasswordAttributesTransfer
    ): RestResponseInterface {
        return $this->getFactory()
            ->createCustomerPasswordWriter()
            ->restorePassword($restCustomerRestorePasswordAttributesTransfer);
    }
}
