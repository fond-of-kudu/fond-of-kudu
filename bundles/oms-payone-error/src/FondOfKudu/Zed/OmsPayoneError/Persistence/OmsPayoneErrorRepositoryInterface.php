<?php

namespace FondOfKudu\Zed\OmsPayoneError\Persistence;

interface OmsPayoneErrorRepositoryInterface
{
    /**
     * @param int $idSalesOrder
     * @param array $errorCodeBetween
     *
     * @return bool
     */
    public function isPaymentPayoneApiLogErrorWithIdSalesOrderAndErrorCodeBetween(
        int $idSalesOrder,
        array $errorCodeBetween
    ): bool;
}
