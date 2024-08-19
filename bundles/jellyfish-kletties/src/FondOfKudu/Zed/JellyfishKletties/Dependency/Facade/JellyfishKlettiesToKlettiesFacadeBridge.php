<?php

namespace FondOfKudu\Zed\JellyfishKletties\Dependency\Facade;

use FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface;
use Generated\Shared\Transfer\KlettiesOrderTransfer;
use Orm\Zed\Kletties\Persistence\FokKlettiesOrder;

class JellyfishKlettiesToKlettiesFacadeBridge implements JellyfishKlettiesToKlettiesFacadeInterface
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface
     */
    protected $facade;

    /**
     * @param \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface $facade
     */
    public function __construct(KlettiesFacadeInterface $facade)
    {
        $this->facade = $facade;
    }

    /**
     * @param \Orm\Zed\Kletties\Persistence\FokKlettiesOrder $klettiesOrder
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function convertKlettiesOrderEntityToTransfer(FokKlettiesOrder $klettiesOrder): KlettiesOrderTransfer
    {
        return $this->facade->convertKlettiesOrderEntityToTransfer($klettiesOrder);
    }
}
