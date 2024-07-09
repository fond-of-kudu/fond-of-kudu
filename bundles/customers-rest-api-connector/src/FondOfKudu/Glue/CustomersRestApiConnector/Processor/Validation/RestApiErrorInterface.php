<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector\Processor\Validation;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface RestApiErrorInterface
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE_CUSTOMER_EMAIL_ALREADY_USED = 'customer.email.already.used';

    /**
     * @var string
     */
    public const ERROR_MESSAGE_CUSTOMER_EMAIL_INVALID = 'customer.email.format.invalid';

    /**
     * @var string
     */
    public const ERROR_MESSAGE_CUSTOMER_EMAIL_LENGTH_EXCEEDED = 'customer.email.length.exceeded';

    /**
     * @var string
     */
    public const ERROR_CUSTOMER_PASSWORD_INVALID = 'customer.password.invalid';

    /**
     * @var string
     */
    public const ERROR_CUSTOMER_TOKEN_INVALID = 'customer.token.invalid';

    /**
     * @uses \Spryker\Zed\Customer\Business\CustomerPasswordPolicy\LengthCustomerPasswordPolicy::GLOSSARY_KEY_PASSWORD_POLICY_ERROR_MAX
     *
     * @var string
     */
    public const ERROR_CUSTOMER_PASSWORD_TOO_LONG = 'customer.password.error.max_length';

    /**
     * @uses \Spryker\Zed\Customer\Business\CustomerPasswordPolicy\LengthCustomerPasswordPolicy::GLOSSARY_KEY_PASSWORD_POLICY_ERROR_MIN
     *
     * @var string
     */
    public const ERROR_CUSTOMER_PASSWORD_TOO_SHORT = 'customer.password.error.min_length';

    /**
     * @uses \Spryker\Zed\Customer\Business\CustomerPasswordPolicy\CharacterSetCustomerPasswordPolicy::GLOSSARY_KEY_PASSWORD_POLICY_ERROR_CHARACTER_SET
     *
     * @var string
     */
    public const ERROR_CUSTOMER_PASSWORD_CHARACTER_SET = 'customer.password.error.character_set';

    /**
     * @uses \Spryker\Zed\Customer\Business\CustomerPasswordPolicy\SequenceCustomerPasswordPolicy::GLOSSARY_KEY_PASSWORD_POLICY_ERROR_SEQUENCE
     *
     * @var string
     */
    public const ERROR_CUSTOMER_PASSWORD_SEQUENCE = 'customer.password.error.sequence';

    /**
     * @uses \Spryker\Zed\Customer\Business\CustomerPasswordPolicy\DenyListCustomerPasswordPolicy::GLOSSARY_KEY_PASSWORD_POLICY_ERROR_DENY_LIST
     *
     * @var string
     */
    public const ERROR_CUSTOMER_PASSWORD_DENY_LIST = 'customer.password.error.deny_list';

    /**
     * @var string
     */
    public const ERROR_CUSTOMER_NOT_FOUND = 'customer.not.found';

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
    ): RestResponseInterface;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addPasswordUpdatedError(RestResponseInterface $restResponse): RestResponseInterface;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     * @param \Generated\Shared\Transfer\CustomerResponseTransfer $customerResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function processCustomerErrorOnPasswordReset(
        RestResponseInterface $restResponse,
        CustomerResponseTransfer $customerResponseTransfer
    ): RestResponseInterface;
}
