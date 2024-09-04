<?php

namespace FondOfKudu\Client\CustomerMergeGuestOrder;

interface CustomerMergeGuestOrderClientInterface
{
    public function updateGuestOrdersByEmail(string $email): bool;
}
