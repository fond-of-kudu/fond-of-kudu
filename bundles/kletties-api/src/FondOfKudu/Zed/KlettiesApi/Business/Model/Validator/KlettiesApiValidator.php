<?php

namespace FondOfKudu\Zed\KlettiesApi\Business\Model\Validator;

use Generated\Shared\Transfer\ApiRequestTransfer;

class KlettiesApiValidator implements KlettiesApiValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    public function validate(ApiRequestTransfer $apiRequestTransfer): array
    {
        return [];
    }
}
