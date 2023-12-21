<?php

namespace FondOfKudu\Zed\OmsPayoneError;

use Codeception\Test\Unit;

class OmsPayoneErrorConfigTest extends Unit
{
    /**
     * @var \FondOfKudu\Zed\OmsPayoneError\OmsPayoneErrorConfig
     */
    protected OmsPayoneErrorConfig $config;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->config = new OmsPayoneErrorConfig();
    }
}
