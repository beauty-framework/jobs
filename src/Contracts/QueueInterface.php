<?php
declare(strict_types=1);

namespace Beauty\Jobs\Contracts;

use Beauty\Jobs\Options\JobOptions;

interface QueueInterface
{
    /**
     * @param JobInterface $job
     * @param JobOptions|null $jobOptions
     * @param string $queue
     * @return void
     */
    public function push(JobInterface $job, JobOptions|null $jobOptions = null, string $queue = 'default'): void;
}