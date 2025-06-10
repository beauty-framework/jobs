<?php
declare(strict_types=1);

namespace Beauty\Jobs\Console\Commands\Generate;

use Beauty\Cli\Commands\Generate\AbstractGeneratorCommand;

class JobCommand extends AbstractGeneratorCommand
{

    /**
     * @return string
     */
    public function name(): string
    {
        return 'generate:job';
    }

    /**
     * @return string|null
     */
    public function description(): string|null
    {
        return 'Create a new job';
    }

    /**
     * @return string
     */
    protected function stubPath(): string
    {
        return __DIR__ . '/../../../../stubs/job.stub';
    }

    /**
     * @return string
     */
    protected function baseNamespace(): string
    {
        return 'App\Jobs';
    }

    /**
     * @return string
     */
    protected function baseDirectory(): string
    {
        return 'app/Jobs';
    }

    /**
     * @return string
     */
    protected function suffix(): string
    {
        return 'Job';
    }
}