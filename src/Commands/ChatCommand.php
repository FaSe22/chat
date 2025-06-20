<?php

namespace Fase\Chat\Commands;

use Illuminate\Console\Command;

class ChatCommand extends Command
{
    public $signature = 'chat';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
