<?php

namespace FondOfKudu\Glue\CustomerMergeGuestOrder;

use FondOfKudu\Glue\CustomerMergeGuestOrder\Processor\OrderUpdater;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfKudu\Client\CustomerMergeGuestOrder\CustomerMergeGuestOrderClientInterface getClient()
 */
class CustomerMergeGuestOrderFactory extends AbstractFactory
{
    /**
     * @return \FondOfKudu\Glue\CustomerMergeGuestOrder\Processor\OrderUpdater
     */
    public function createOrderUpdater(): OrderUpdater
    {
        return new OrderUpdater($this->getClient());
    }
}
