<?php

namespace FondOfKudu\Zed\KlettiesApi\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer;

interface TransferMapperInterface
{
    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer
     */
    public function toTransfer(array $data): FokKlettiesOrderEntityTransfer;

    /**
     * @param array $data
     *
     * @return array<\Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer>
     */
    public function toTransferCollection(array $data): array;
}
