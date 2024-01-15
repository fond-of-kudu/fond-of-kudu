<?php

namespace FondOfKudu\Zed\OmsRetryCaptureProcess;

use FondOfKudu\Shared\OmsPayoneError\OmsPayoneErrorConstants;
use FondOfKudu\Shared\OmsRetryCaptureProcess\OmsRetryCaptureProcessConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class OmsRetryCaptureProcessConfig extends AbstractBundleConfig
{
    /**
     * @return int
     */
    public function getHoursAfterCaptureFinalFailed(): int
    {
        return $this->get(OmsRetryCaptureProcessConstants::HOURS_AFTER_CAPTURE_FINAL_FAILED, 12);
    }

    /**
     * @return array<string>
     */
    public function getCaptureFailTestRecipients(): array
    {
        return $this->get(OmsPayoneErrorConstants::CAPTURE_FAIL_TEST_RECIPIENTS, ['capture-fail@fondof.de']);
    }
}
