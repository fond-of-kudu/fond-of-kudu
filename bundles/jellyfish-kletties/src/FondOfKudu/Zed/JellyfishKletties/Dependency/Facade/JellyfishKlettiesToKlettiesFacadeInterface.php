<?php

namespace FondOfKudu\Zed\JellyfishKletties\Dependency\Facade;

use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrder;

interface JellyfishKlettiesToKlettiesFacadeInterface
{
    /**
     * @param \Orm\Zed\Kletties\Persistence\FokKlettiesOrder $klettiesOrder
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function convertKlettiesOrderEntityToTransfer(FokKlettiesOrder $klettiesOrder): KlettiesOrderTransfer;
}
