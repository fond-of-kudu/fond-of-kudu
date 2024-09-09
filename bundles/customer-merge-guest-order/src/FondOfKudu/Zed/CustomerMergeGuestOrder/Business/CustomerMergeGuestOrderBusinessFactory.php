<?php

namespace FondOfKudu\Zed\CustomerMergeGuestOrder\Business;

use FondOfKudu\Zed\CustomerMergeGuestOrder\Business\Checkout\OrderPreSaveHook;
use FondOfKudu\Zed\CustomerMergeGuestOrder\Business\Processor\OrderUpdater;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderEntityManagerInterface getEntityManager()
 * @method \FondOfKudu\Zed\CustomerMergeGuestOrder\Persistence\CustomerMergeGuestOrderRepositoryInterface getRepository()
 */
class CustomerMergeGuestOrderBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\CustomerMergeGuestOrder\Business\Processor\OrderUpdater
     */
    public function createOrderUpdater(): OrderUpdater
    {
        return new OrderUpdater($this->getEntityManager());
    }

    /**
     * @return \FondOfKudu\Zed\CustomerMergeGuestOrder\Business\Checkout\OrderPreSaveHook
     */
    public function createOrderPreSaveHook(): OrderPreSaveHook
    {
        return new OrderPreSaveHook($this->getRepository());
    }
}
