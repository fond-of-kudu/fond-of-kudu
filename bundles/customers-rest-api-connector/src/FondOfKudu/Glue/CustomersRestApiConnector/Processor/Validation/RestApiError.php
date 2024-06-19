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

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     * @param \Generated\Shared\Transfer\CustomerResponseTransfer $customerResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function processKnownCustomerError(RestResponseInterface $restResponse, CustomerResponseTransfer $customerResponseTransfer): RestResponseInterface
    {
        foreach ($customerResponseTransfer->getErrors() as $customerErrorTransfer) {
            if ($customerErrorTransfer->getMessage() === static::ERROR_CUSTOMER_TOKEN_INVALID) {
                $restResponse = $this->addInvalidTokenError($restResponse);

                continue;
            }

            if ($customerErrorTransfer->getMessage() === static::ERROR_MESSAGE_CUSTOMER_EMAIL_ALREADY_USED) {
                $restResponse = $this->addCustomerAlreadyExistsError($restResponse);

                continue;
            }

            if ($customerErrorTransfer->getMessage() === static::ERROR_MESSAGE_CUSTOMER_EMAIL_INVALID) {
                $restResponse = $this->addCustomerEmailInvalidError($restResponse);

                continue;
            }

            if ($customerErrorTransfer->getMessage() === static::ERROR_MESSAGE_CUSTOMER_EMAIL_LENGTH_EXCEEDED) {
                $restResponse = $this->addCustomerEmailLengthExceededError($restResponse);

                continue;
            }

            if ($customerErrorTransfer->getMessage() === static::ERROR_CUSTOMER_PASSWORD_INVALID) {
                $restResponse = $this->addPasswordNotValidError($restResponse);

                continue;
            }

            if ($customerErrorTransfer->getMessage() === static::ERROR_CUSTOMER_PASSWORD_TOO_LONG) {
                $restResponse = $this->addPasswordTooLong($restResponse);

                continue;
            }

            if ($customerErrorTransfer->getMessage() === static::ERROR_CUSTOMER_PASSWORD_TOO_SHORT) {
                $restResponse = $this->addPasswordTooShort($restResponse);

                continue;
            }

            if ($customerErrorTransfer->getMessage() === static::ERROR_CUSTOMER_PASSWORD_CHARACTER_SET) {
                $restResponse = $this->addPasswordInvalidCharacterSet($restResponse);

                continue;
            }

            if ($customerErrorTransfer->getMessage() === static::ERROR_CUSTOMER_PASSWORD_SEQUENCE) {
                $restResponse = $this->addPasswordSequenceNotAllowed($restResponse);

                continue;
            }

            if ($customerErrorTransfer->getMessage() === static::ERROR_CUSTOMER_PASSWORD_DENY_LIST) {
                $restResponse = $this->addPasswordInDenyList($restResponse);

                continue;
            }
        }

        return $restResponse;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addInvalidTokenError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomersRestApiConfig::RESPONSE_CODE_RESTORE_PASSWORD_KEY_INVALID)
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setDetail(CustomersRestApiConfig::RESPONSE_DETAILS_RESTORE_PASSWORD_KEY_INVALID);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addCustomerAlreadyExistsError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_ALREADY_EXISTS)
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setDetail(CustomersRestApiConfig::RESPONSE_MESSAGE_CUSTOMER_ALREADY_EXISTS);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addCustomerEmailInvalidError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_EMAIL_INVALID)
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setDetail(CustomersRestApiConfig::RESPONSE_MESSAGE_CUSTOMER_EMAIL_INVALID);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addCustomerEmailLengthExceededError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_EMAIL_LENGTH_EXCEEDED)
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setDetail(CustomersRestApiConfig::RESPONSE_MESSAGE_CUSTOMER_EMAIL_LENGTH_EXCEEDED);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addPasswordNotValidError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomersRestApiConfig::RESPONSE_CODE_INVALID_PASSWORD)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(CustomersRestApiConfig::RESPONSE_DETAILS_INVALID_PASSWORD);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addPasswordTooLong(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_PASSWORD_TOO_LONG)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(CustomersRestApiConfig::RESPONSE_MESSAGE_CUSTOMER_PASSWORD_TOO_LONG);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addPasswordTooShort(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_PASSWORD_TOO_SHORT)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(CustomersRestApiConfig::RESPONSE_MESSAGE_CUSTOMER_PASSWORD_TOO_SHORT);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addPasswordInvalidCharacterSet(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_PASSWORD_INVALID_CHARACTER_SET)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(CustomersRestApiConfig::RESPONSE_MESSAGE_CUSTOMER_PASSWORD_INVALID_CHARACTER_SET);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addPasswordSequenceNotAllowed(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_PASSWORD_SEQUENCE_NOT_ALLOWED)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(CustomersRestApiConfig::RESPONSE_MESSAGE_CUSTOMER_PASSWORD_SEQUENCE_NOT_ALLOWED);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addPasswordInDenyList(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_PASSWORD_DENY_LIST)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail(CustomersRestApiConfig::RESPONSE_MESSAGE_CUSTOMER_PASSWORD_DENY_LIST);

        return $restResponse->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     * @param string $errorMessage
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addPasswordChangeError(RestResponseInterface $restResponse, string $errorMessage): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomersRestApiConfig::RESPONSE_CODE_PASSWORD_CHANGE_FAILED)
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setDetail($errorMessage);

        return $restResponse->addError($restErrorMessageTransfer);
    }
}
