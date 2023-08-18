<?php

namespace FondOfKudu\Zed\OmsOrderConfirmation\Business;

use FondOfKudu\Zed\OmsOrderConfirmation\Business\Mail\RevocationPolicyMailExpander;
use FondOfKudu\Zed\OmsOrderConfirmation\Business\Mail\RevocationPolicyMailExpanderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfKudu\Zed\OmsOrderConfirmation\OmsOrderConfirmationConfig getConfig()
 */
class OmsOrderConfirmationBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfKudu\Zed\OmsOrderConfirmation\Business\Mail\RevocationPolicyMailExpanderInterface
     */
    public function createRevocationPolicyMailExpander(): RevocationPolicyMailExpanderInterface
    {
        return new RevocationPolicyMailExpander($this->getConfig());
    }
}
