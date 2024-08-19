<?php

namespace FondOfKudu\Zed\KlettiesApi\Business;

use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;

interface KlettiesApiFacadeInterface
{
    /**
     * @param int $idKlettiesOrder
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function updateKlettiesOrder(int $idKlettiesOrder, ApiDataTransfer $apiDataTransfer): ApiItemTransfer;

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\ApiDispatchingException
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function findKlettiesOrder(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer;

    /**
     * Specification:
     * - Validates the given API data and returns an array of errors if necessary.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    public function validate(ApiRequestTransfer $apiRequestTransfer): array;
}
