<?php

namespace FondOfKudu\Zed\OmsRetryCaptureProcess;

use Codeception\Test\Unit;

class OmsRetryCaptureProcessConfigTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\OmsRetryCaptureProcess\OmsRetryCaptureProcessConfig
     */
    protected OmsRetryCaptureProcessConfig $config;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->config = new OmsRetryCaptureProcessConfig();
    }

    /**
     * @return void
     */
    public function testGetHoursAfterCaptureFinalFailed(): void
    {
        static::assertEquals($this->config->getHoursAfterCaptureFinalFailed(), 12);
    }
}
