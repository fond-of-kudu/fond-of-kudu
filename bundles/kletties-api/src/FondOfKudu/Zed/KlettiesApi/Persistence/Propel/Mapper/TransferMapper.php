<?php

namespace FondOfKudu\Zed\KlettiesApi\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer;

class TransferMapper implements TransferMapperInterface
{
    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer
     */
    public function toTransfer(array $data): FokKlettiesOrderEntityTransfer
    {
        $klettiesOrderTransfer = new FokKlettiesOrderEntityTransfer();

        return $klettiesOrderTransfer->fromArray($data, true);
    }

    /**
     * @param array $data
     *
     * @return array<\Generated\Shared\Transfer\FokKlettiesOrderEntityTransfer>
     */
    public function toTransferCollection(array $data): array
    {
        $transferList = [];
        foreach ($data as $itemData) {
            $transferList[] = $this->toTransfer($itemData);
        }

        return $transferList;
    }
}
