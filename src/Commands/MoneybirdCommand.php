<?php

namespace Sensson\Moneybird\Commands;

use Illuminate\Console\Command;

class MoneybirdCommand extends Command
{
    public $signature = 'laravel-moneybird';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
