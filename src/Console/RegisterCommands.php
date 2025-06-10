<?php
declare(strict_types=1);

namespace Beauty\Jobs\Console;

use Beauty\Jobs\Console\Commands\Generate\JobCommand;

class RegisterCommands
{
    /**
     * @return \class-string[]
     */
    public static function commands(): array
    {
        return [
            JobCommand::class,
        ];
    }
}