<?php

namespace FondOfKudu\Zed\OmsPayoneError\Persistence;

interface OmsPayoneErrorRepositoryInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    public function findPaymentPayoneApiLogErrorWithIdSalesOrder(int $idSalesOrder): string;
}
