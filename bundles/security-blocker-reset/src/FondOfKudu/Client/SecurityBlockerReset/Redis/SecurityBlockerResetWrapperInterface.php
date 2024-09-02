<?php

namespace FondOfKudu\Client\SecurityBlockerReset\Redis;

interface SecurityBlockerResetWrapperInterface
{
    /**
     * @param array<string> $keys
     *
     * @return int
     */
    public function del(array $keys): int;
}
