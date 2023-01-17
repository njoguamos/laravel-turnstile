<?php

namespace NjoguAmos\Turnstile\Commands;

use Illuminate\Console\Command;

class TurnstileCommand extends Command
{
    public $signature = 'laravel-turnstile';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
