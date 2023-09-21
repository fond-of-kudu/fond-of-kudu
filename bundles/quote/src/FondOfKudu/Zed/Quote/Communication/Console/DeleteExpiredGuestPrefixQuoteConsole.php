<?php

namespace FondOfKudu\Zed\Quote\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \FondOfKudu\Zed\Quote\Business\QuoteFacadeInterface getFacade()
 * @method \FondOfKudu\Zed\Quote\Persistence\QuoteRepositoryInterface getRepository()
 */
class DeleteExpiredGuestPrefixQuoteConsole extends Console
{
    /**
     * @var string
     */
    protected const COMMAND_NAME = 'quote:delete-expired-guest-prefix-quotes';

    /**
     * @var string
     */
    protected const COMMAND_DESCRIPTION = 'Delete all expired guest prefix quotes.';

    /**
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::COMMAND_DESCRIPTION);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getFacade()->deleteExpiredGuestPrefixQuote();

        return static::CODE_SUCCESS;
    }
}
