<?php
declare(strict_types=1);

namespace Beauty\Jobs;

use Beauty\Jobs\Contracts\JobInterface;
use Beauty\Jobs\Options\JobOptions;
use Psr\Container\ContainerInterface;

abstract class AbstractJob implements JobInterface
{
    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @var JobOptions|null
     */
    protected JobOptions|null $jobOptions = null;

    /**
     * @var string|null
     */
    protected string|null $customQueue = null;

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return JobOptions|null
     */
    public function options(): JobOptions|null
    {
        return $this->jobOptions;
    }

    /**
     * @return string|null
     */
    public function queue(): string|null
    {
        return $this->customQueue;
    }

    /**
     * @param int $seconds
     * @return $this
     */
    public function withDelay(int $seconds): static
    {
        $this->getOrCreateOptions()->delay = $seconds;
        return $this;
    }

    /**
     * @param int $priority
     * @return $this
     */
    public function withPriority(int $priority): static
    {
        $this->getOrCreateOptions()->priority = $priority;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function withHeader(string $key, string $value): static
    {
        $this->getOrCreateOptions()->headers[$key] = $value;
        return $this;
    }

    /**
     * @param string $queue
     * @return $this
     */
    public function onQueue(string $queue): static
    {
        $this->customQueue = $queue;
        return $this;
    }

    /**
     * @param string ...$tags
     * @return $this
     */
    public function tags(string ...$tags): static
    {
        $this->getOrCreateOptions()->headers['tags'] = implode(',', $tags);
        return $this;
    }

    /**
     * @return JobOptions
     */
    protected function getOrCreateOptions(): JobOptions
    {
        if ($this->jobOptions === null) {
            $this->jobOptions = new JobOptions();
        }

        return $this->jobOptions;
    }
}