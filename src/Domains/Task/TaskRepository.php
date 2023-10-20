<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;
use Tymeshift\PhpTest\Interfaces\EntityCollection;
use Tymeshift\PhpTest\Interfaces\EntityInterface;
use Tymeshift\PhpTest\Interfaces\RepositoryInterface;
use Exception;
use Tymeshift\PhpTest\Traits\ArrayTrait;

class TaskRepository implements RepositoryInterface
{
    use ArrayTrait;
    public function __construct(
        private TaskStorage $storage,
        private TaskFactory $factory
    ) {
    }

    public function getById(int $id): EntityInterface
    {
        $array = $this->search($this->storage->getById($id), ['id' => $id]);

        return $this->factory->createEntity(
            array_shift($array)
        );
    }

    /**
     * @throws Exception
     */
    public function getByScheduleId(int $scheduleId):TaskCollection
    {
       $task = $this->storage->getByScheduleId($scheduleId);

       if (empty($task)) {
           throw new Exception('Schedule is not set');
       }

        return $this->factory->createCollection($task);
    }

    /**
     * @throws InvalidCollectionDataProvidedException
     */
    public function getByIds(array $ids): TaskCollection
    {
        return $this->factory->createCollection(
            $this->storage->getByIds($ids)
        );
    }
}
