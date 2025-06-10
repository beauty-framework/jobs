<?php
declare(strict_types=1);

namespace Beauty\Jobs\Queue;

use Beauty\Jobs\Contracts\JobInterface;
use Beauty\Jobs\Contracts\QueueInterface;
use Beauty\Jobs\Options\JobOptions;
use Spiral\RoadRunner\Jobs\Jobs;
use Spiral\RoadRunner\Jobs\Options as RRJobOptions;

class RoadRunnerQueue implements QueueInterface
{
    /**
     * @param Jobs $jobs
     */
    public function __construct(
        private Jobs $jobs,
    )
    {
    }

    /**
     * @param JobInterface $job
     * @param JobOptions|null $jobOptions
     * @param string $queue
     * @return void
     */
    public function push(JobInterface $job, JobOptions|null $jobOptions = null, string $queue = 'default'): void
    {
        $queue = $this->jobs->connect($queue);
        $payload = \Opis\Closure\serialize($job);

        $options = new RRJobOptions();

        if ($jobOptions?->delay !== null) {
            $options = $options->withDelay($jobOptions->delay);
        }

        if ($jobOptions?->priority !== null) {
            $options = $options->withPriority($jobOptions->priority);
        }

        if (!empty($jobOptions?->headers)) {
            foreach ($jobOptions->headers as $key => $header) {
                $options = $options->withHeader($key, $header);
            }
        }

        $queue->push($job::class, $payload, $options);
    }
}