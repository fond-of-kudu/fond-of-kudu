<?php

namespace FondOfKudu\Zed\OmsPayoneError\Persistence;

use Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLogQuery;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface OmsPayoneErrorQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Payone\Persistence\SpyPaymentPayoneApiLogQuery|null
     */
    public function createApiLogsByOrderId(int $idSalesOrder): ?SpyPaymentPayoneApiLogQuery;
}
