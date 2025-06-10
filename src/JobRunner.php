<?php
declare(strict_types=1);

namespace Beauty\Jobs;

use Beauty\Jobs\Contracts\JobInterface;
use Psr\Container\ContainerInterface;
use Spiral\RoadRunner\Jobs\ConsumerInterface;
use Spiral\RoadRunner\Jobs\Task\ReceivedTask;
use Spiral\RoadRunner\Jobs\Task\ReceivedTaskInterface;

class JobRunner
{
    public function __construct(
        private ConsumerInterface $consumer,
        private ContainerInterface $container,
    ) {}

    public function run(): void
    {
        while ($task = $this->consumer->waitTask()) {
            if ($task) {
                $this->handleTask($task);
            }
        }
    }

    protected function handleTask(ReceivedTaskInterface $task): void
    {
        try {
            /** @var JobInterface $job */
            $job = \Opis\Closure\unserialize($task->getPayload());

            if (!($job instanceof JobInterface)) {
                throw new \RuntimeException("Invalid job received: must implement JobInterface");
            }

            if ($job instanceof AbstractJob) {
                $job->setContainer($this->container);
            }

            $job->handle();

            $task->ack();
        } catch (\Throwable $e) {
            $task->nack($e->getMessage());
        }
    }
}