# Beauty Jobs

This package provides a RoadRunner-compatible jobs system for the Beauty PHP framework, with Laravel-style fluent APIs, DI container support, and full PSR compatibility.

---

## Installation

```bash
composer require beauty-framework/jobs
```

---

## Features
* Works with RoadRunner pipelines
* Works with `memory`, `AMQP`, `Kafka`, etc.
* Fluent Job options API: `withDelay()`, `onQueue()`, `tags()`
* Uses `Opis\Closure` for serializable job payloads
* Integrates with DI container (`ContainerInterface`)

---

## Requirements

* RoadRunner installed and configured
* jobs plugin configured in `.rr.yaml`
* PHP 8.1+

---

## Creating a Job

To generate a job, use the built-in console command:

```bash
./beauty generate:job TestJob
```

This will create `app/Jobs/TestJob.php` with a default stub implementation.

### Example job:

```php
<?php
namespace App\Jobs;

use Beauty\Jobs\AbstractJob;

class TestJob extends AbstractJob
{
    public function __construct(
        public readonly string $message = 'Hello from job!',
    ) {}

    public function handle(): void
    {
        file_put_contents(storage_path('logs/test.log'), $this->message . PHP_EOL, FILE_APPEND);
    }
}
```

---

## Dispatching a Job

Jobs are dispatched via the `Dispatcher` class. You can resolve it via the container:

```php
use App\Jobs\TestJob;
use Beauty\Jobs\Dispatcher;

public function someControllerMethod(Dispatcher $dispatcher)
{
    $job = (new TestJob('123'))
        ->withDelay(5)
        ->onQueue('emails')
        ->tags('welcome', 'user:123');

    $dispatcher->dispatch($job);
}
```

You can also override options:

```php
$dispatcher->dispatch($job, options: new JobOptions(timeout: 30), queue: 'critical');
```

---

## Fluent API available

* `withDelay(int $seconds)`
* `withTimeout(int $seconds)`
* `withMaxTries(int $tries)`
* `withHeader(string $key, string $value)`
* `onQueue(string $name)`
* `tags(string ...$tags)`

These options are embedded in the serialized job and automatically passed to RoadRunner.

---

## Under the Hood

* `AbstractJob` implements `JobInterface` and includes DI container awareness
* `JobRunner` handles job execution
* Serialized with `Opis\Closure`
* RoadRunner feeds the job through `pipes`, and the worker picks it up via `Consumer`

---

## RoadRunner Configuration

Reference: [RoadRunner Jobs Plugin Docs](https://docs.roadrunner.dev/docs/queues-and-jobs/overview-queues)

Sample `.rr.yaml`:

```yaml
server:
  command: "php workers/rr-worker.php"
  relay: pipes

jobs:
  consume: ["default"]
  pool:
    command: "php workers/rr-worker.php"
    num_workers: 4
    debug: true
  pipelines:
    default:
      driver: memory
      config:
        priority: 1
        prefetch: 100
  consumers:
    default:
      pipeline: default
```

Make sure your worker script (e.g., `rr-worker.php`) is capable of receiving jobs and invoking `JobRunner`.

---

## License

MIT
