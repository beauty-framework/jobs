<?php
declare(strict_types=1);

namespace Beauty\Jobs\Console;

use Beauty\Cli\Console\Contracts\CommandsRegistryInterface;
use Beauty\Jobs\Console\Commands\Generate\JobCommand;

class RegisterCommands implements CommandsRegistryInterface
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