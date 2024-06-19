<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\CustomersRestApi\CustomersRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class RestApiError implements RestApiErrorInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     * @param string $passwordFieldName
     * @param string $passwordConfirmFieldName
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addPasswordsDoNotMatchError(
        RestResponseInterface $restResponse,
        string $passwordFieldName,
        string $passwordConfirmFieldName
    ): RestResponseInterface {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomersRestApiConfig::RESPONSE_CODE_PASSWORDS_DONT_MATCH)
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setDetail(sprintf(CustomersRestApiConfig::RESPONSE_DETAILS_PASSWORDS_DONT_MATCH, $passwordFieldName, $passwordConfirmFieldName));

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     * @param \Generated\Shared\Transfer\CustomerResponseTransfer $customerResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function processCustomerErrorOnPasswordReset(
        RestResponseInterface $restResponse,
        CustomerResponseTransfer $customerResponseTransfer
    ): RestResponseInterface {
        $restResponse = $this->processKnownCustomerError($restResponse, $customerResponseTransfer);

        if (!count($restResponse->getErrors())) {
            return $this->addPasswordChangeError(
                $restResponse,
                CustomersRestApiConfig::RESPONSE_DETAILS_PASSWORD_CHANGE_FAILED,
            );
        }

        return $restResponse;
    }
}
