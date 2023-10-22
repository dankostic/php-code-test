<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Services;

use Exception;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleEntity;
use Tymeshift\PhpTest\Domains\Task\TaskEntity;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;
use Tymeshift\PhpTest\Factories\ScheduleItemFactory;
use Tymeshift\PhpTest\Interfaces\EntityInterface;
use Tymeshift\PhpTest\Repositories\ScheduleRepository;
use Tymeshift\PhpTest\Repositories\TaskRepository;

class ScheduleService
{
    public function __construct(
        private ScheduleRepository $scheduleRepository,
        private TaskRepository $taskRepository,
        private ScheduleItemFactory $scheduleItemFactory
    ) {
    }

    /**
     * @throws StorageDataMissingException
     * @throws Exception
     */
    public function addScheduleEntityItems(int $id): EntityInterface
    {
        $schedule = $this->scheduleRepository->getById($id);
        $tasks = $this->taskRepository->getByScheduleId($id);

        /** @var TaskEntity $task */
        /** @var ScheduleEntity $schedule */
        /** @var array $addItems */

        foreach ($tasks as $task) {
            $addItems[] = $this->scheduleItemFactory->createEntity($task);
        }

        return $schedule->setItems($addItems);
    }
}
