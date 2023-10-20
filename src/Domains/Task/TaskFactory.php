<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Exceptions\InvalidCollectionDataProvidedException;
use Tymeshift\PhpTest\Interfaces\CollectionInterface;
use Tymeshift\PhpTest\Interfaces\EntityInterface;
use Tymeshift\PhpTest\Interfaces\FactoryInterface;

class TaskFactory implements FactoryInterface
{
    public function createEntity(array $data): EntityInterface
    {

        $entity = new TaskEntity();

        return $entity
            ->setId(!empty($data['id']) && is_int($data['id'])
                ? $data['id'] : null)
            ->setScheduleId(!empty($data['schedule_id']) && is_int($data['schedule_id'])
                ? $data['schedule_id'] : null)
            ->setStartTime(!empty($data['start_time']) && is_int($data['start_time'])
                ? (new \DateTime())->setTimestamp($data['start_time']) : new \DateTime())
            ->setDuration(!empty($data['duration']) && is_int($data['duration'])
                ? (new \DateTime())->setTimestamp($data['duration']) : new \DateTime());
    }

    /**
     * @throws InvalidCollectionDataProvidedException
     */
    public function createCollection(array $data):CollectionInterface
    {
        return (new TaskCollection())->createFromArray($data, $this);
    }
}