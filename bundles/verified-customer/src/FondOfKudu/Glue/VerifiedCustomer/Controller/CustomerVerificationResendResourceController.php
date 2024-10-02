<?php

namespace FondOfKudu\Glue\VerifiedCustomer\Controller;

use Generated\Shared\Transfer\RestCustomerVerificationResendAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfKudu\Glue\VerifiedCustomer\VerifiedCustomerFactory getFactory()
 */
class CustomerVerificationResendResourceController extends AbstractController
{
    /**
     * @Glue({
     *     "post": {
     *          "summary": [
     *              "Resends custmer verification link."
     *          ],
     *          "parameters": [{
     *              "ref": "acceptLanguage"
     *          }],
     *          "responses": {
     *              "204": "No content.",
     *              "422": "User is already verified."
     *          },
     *          "isEmptyResponse": true
     *     }
     * })
     *
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCustomerVerificationResendAttributesTransfer $restCustomerVerificationResendAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function postAction(
        RestRequestInterface $restRequest,
        RestCustomerVerificationResendAttributesTransfer $restCustomerVerificationResendAttributesTransfer
    ): RestResponseInterface {
        return $this->getFactory()
            ->createCustomerVerificactionSender()
            ->resendAccountVerification($restRequest);
    }
}
