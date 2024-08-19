<?php

namespace FondOfKudu\Zed\KlettiesApi\Dependency\Facade;

use FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface;
use Generated\Shared\Transfer\KlettiesOrderTransfer;

class KlettiesApiToKlettiesFacadeBridge implements KlettiesApiToKlettiesFacadeInterface
{
    /**
     * @var \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface
     */
    protected KlettiesFacadeInterface $facade;

    /**
     * @param \FondOfKudu\Zed\Kletties\Business\KlettiesFacadeInterface $klettiesFacade
     */
    public function __construct(KlettiesFacadeInterface $klettiesFacade)
    {
        $this->facade = $klettiesFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\KlettiesOrderTransfer $klettiesOrderTransfer
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer
     */
    public function updateKlettiesOrder(KlettiesOrderTransfer $klettiesOrderTransfer): KlettiesOrderTransfer
    {
        return $this->facade->updateKlettiesOrder($klettiesOrderTransfer);
    }

    /**
     * @param int $id
     *
     * @return \Generated\Shared\Transfer\KlettiesOrderTransfer|null
     */
    public function findKlettiesOrderById(int $id): ?KlettiesOrderTransfer
    {
        return $this->facade->findKlettiesOrderById($id);
    }
}
