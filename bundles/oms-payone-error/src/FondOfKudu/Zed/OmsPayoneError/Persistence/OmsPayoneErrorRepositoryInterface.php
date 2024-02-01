<?php

namespace FondOfKudu\Zed\OmsPayoneError\Persistence;

interface OmsPayoneErrorRepositoryInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return string|null
     */
    public function findPaymentPayoneApiLogErrorWithIdSalesOrder(int $idSalesOrder): ?string;
}
