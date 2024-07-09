<?php

namespace FondOfKudu\Glue\CustomersRestApiConnector;

use FondOfKudu\Shared\CustomerPasswordUpdatedAtConnector\CustomerPasswordUpdatedAtConnectorConstants;
use Spryker\Glue\Kernel\AbstractBundleConfig;

class CustomersRestApiConnectorConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const RESOURCE_CUSTOMERS = 'customers';

    /**
     * @var string
     */
    public const RESPONSE_CODE_PASSWORD_UPDATED_ERROR = '410';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CUSTOMER_ALREADY_EXISTS = '400';

    /**
     * @var string
     */
    public const RESPONSE_MESSAGE_CUSTOMER_ALREADY_EXISTS = 'If this email address is already in use, you will receive a password reset link. Otherwise you must first validate your e-mail address to finish registration. Please check your e-mail.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_PASSWORDS_DONT_MATCH = '406';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_PASSWORDS_DONT_MATCH = 'Value in field %s should be identical to value in the %s field.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_PASSWORD_CHANGE_FAILED = '407';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_PASSWORD_CHANGE_FAILED = 'Failed to change password.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_INVALID_PASSWORD = '408';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_INVALID_PASSWORD = 'Invalid password';

    /**
     * @var string
     */
    public const RESPONSE_CODE_RESTORE_PASSWORD_KEY_INVALID = '415';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_RESTORE_PASSWORD_KEY_INVALID = 'Restore password key is not valid.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CUSTOMER_EMAIL_INVALID = '416';

    /**
     * @var string
     */
    public const RESPONSE_MESSAGE_CUSTOMER_EMAIL_INVALID = 'Invalid Email address format.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CUSTOMER_EMAIL_LENGTH_EXCEEDED = '417';

    /**
     * @var string
     */
    public const RESPONSE_MESSAGE_CUSTOMER_EMAIL_LENGTH_EXCEEDED = 'Email is too long. It should have 100 characters or less.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CUSTOMER_PASSWORD_TOO_SHORT = '418';

    /**
     * @var string
     */
    public const RESPONSE_MESSAGE_CUSTOMER_PASSWORD_TOO_SHORT = 'The password is too short.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CUSTOMER_PASSWORD_TOO_LONG = '419';

    /**
     * @var string
     */
    public const RESPONSE_MESSAGE_CUSTOMER_PASSWORD_TOO_LONG = 'The password is too long.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CUSTOMER_PASSWORD_INVALID_CHARACTER_SET = '420';

    /**
     * @var string
     */
    public const RESPONSE_MESSAGE_CUSTOMER_PASSWORD_INVALID_CHARACTER_SET = 'The password character set is invalid.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CUSTOMER_PASSWORD_SEQUENCE_NOT_ALLOWED = '421';

    /**
     * @var string
     */
    public const RESPONSE_MESSAGE_CUSTOMER_PASSWORD_SEQUENCE_NOT_ALLOWED = 'The password contains sequence of the same character.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CUSTOMER_PASSWORD_DENY_LIST = '422';

    /**
     * @var string
     */
    public const RESPONSE_MESSAGE_CUSTOMER_PASSWORD_DENY_LIST = 'The password is listed as common.';

    /**
     * @var string
     */
    public const RESOURCE_CUSTOMER_RESTORE_PASSWORD = 'customer-restore-password';

    /**
     * @var string
     */
    public const CONTROLLER_CUSTOMER_RESTORE_PASSWORD = 'customer-restore-password-resource';

    /**
     * @var string
     */
    public const CONTROLLER_CUSTOMER_PASSWORD_UPDATED = 'customer-password-updated-resource';

    /**
     * @var string
     */
    public const RESOURCE_CUSTOMER_PASSWORD_UPDATED = 'customer-password-updated';

    /**
     * @return string
     */
    public function getResourceCustomerRestorePassword(): string
    {
        return $this->get(
            CustomerPasswordUpdatedAtConnectorConstants::RESOURCE_CUSTOMER_RESTORE_PASSWORD_CUSTOM,
            static::RESOURCE_CUSTOMER_RESTORE_PASSWORD,
        );
    }
}
