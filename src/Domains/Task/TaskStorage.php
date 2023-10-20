<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Components\HttpClientInterface;
use Tymeshift\PhpTest\Enums\HttpRequestMethods;
use Tymeshift\PhpTest\Interfaces\StorageInterface;
use Tymeshift\PhpTest\Providers\TaskProvider;

class TaskStorage extends TaskProvider implements StorageInterface
{
    public function __construct(
        private HttpClientInterface $client
    ) {
    }

    public function getById(int $id): array
    {
        return $this->client->request(self::GET, $this->getSingleTask($id));
    }

    public function getByScheduleId(int $id): array
    {
        return $this->client->request(self::GET, $this->getSingleTaskFromSchedule($id));
    }

    public function getByIds(array $ids): array
    {
        return $this->client->request(self::GET, $this->getTasksByIds($ids));
    }
}
