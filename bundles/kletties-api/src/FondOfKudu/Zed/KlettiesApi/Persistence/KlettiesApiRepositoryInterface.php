<?php

namespace FondOfKudu\Zed\KlettiesApi\Persistence;

use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer;

interface KlettiesApiRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function find(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer;

    /**
     * @param \Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer $orderEntityTransfer
     *
     * @throws \FondOfKudu\Zed\Kletties\Exception\KlettiesOrderNotFoundException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function convert(FokKlettiesOrderEntityTransfer $orderEntityTransfer): ApiItemTransfer;
}
