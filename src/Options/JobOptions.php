<?php
declare(strict_types=1);

namespace Beauty\Jobs\Options;

final class JobOptions
{
    /**
     * @param int|null $delay
     * @param int|null $priority
     * @param array<string, string> $headers
     */
    public function __construct(
        public int|null $delay = null,
        public int|null $priority = null,
        public array $headers = [],
    )
    {
    }

    /**
     * @param int $seconds
     * @return self
     */
    public function withDelay(int $seconds): self
    {
        $this->delay = $seconds;

        return $this;
    }

    /**
     * @param int $priority
     * @return self
     */
    public function withPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @param array<string, string> $headers
     * @return self
     */
    public function withHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }
}