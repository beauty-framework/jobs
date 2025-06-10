<?php
declare(strict_types=1);

namespace Beauty\Jobs\Contracts;

use Beauty\Jobs\Options\JobOptions;

interface JobInterface extends \JsonSerializable
{
    /**
     * @return void
     */
    public function handle(): void;

    /**
     * @return JobOptions|null
     */
    public function options(): JobOptions|null;
}