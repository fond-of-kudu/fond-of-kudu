<?php

namespace FondOfKudu\Zed\OmsPayoneError;

use FondOfKudu\Shared\OmsPayoneError\OmsPayoneErrorConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class OmsPayoneErrorConfig extends AbstractBundleConfig
{
    /**
     * @return array<string>
     */
    public function getCaptureFailTestRecipients(): array
    {
        return $this->get(OmsPayoneErrorConstants::CAPTURE_FAIL_TEST_RECIPIENTS, ['capture-fail@fondof.de']);
    }
}
