<?php
declare(strict_types=1);

namespace Beauty\Jobs;

use Beauty\Jobs\Contracts\JobInterface;
use Beauty\Jobs\Contracts\QueueInterface;
use Beauty\Jobs\Options\JobOptions;

class Dispatcher
{
    /**
     * @param QueueInterface $queue
     */
    public function __construct(
        private QueueInterface $queue,
    )
    {
    }

    /**
     * @param JobInterface $job
     * @param JobOptions|null $options
     * @param string $queue
     * @return void
     */
    public function dispatch(JobInterface $job, JobOptions|null $options = null, string $queue = 'default'): void
    {
        $queueName = method_exists($job, 'queue') && $job->queue() ? $job->queue() : $queue;

        $this->queue->push($job, $options ?? $job->options(), $queueName);
    }
}