<?php

namespace FondOfKudu\Zed\OmsOrderConfirmation;

use FondOfKudu\Shared\OmsOrderConfirmation\OmsOrderConfirmationConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class OmsOrderConfirmationConfig extends AbstractBundleConfig
{
    /**
     * @return array<string>
     */
    public function getRevocationPolicyUrl(): array
    {
        return $this->get(OmsOrderConfirmationConstants::REVOCATION_POLICY_URL, []);
    }
}
