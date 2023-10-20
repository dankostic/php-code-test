<?php

namespace Tymeshift\PhpTest\Repositories;

use Tymeshift\PhpTest\Domains\Schedule\ScheduleStorage;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;
use Tymeshift\PhpTest\Interfaces\CollectionInterface;
use Tymeshift\PhpTest\Interfaces\EntityInterface;
use Tymeshift\PhpTest\Interfaces\FactoryInterface;
use Tymeshift\PhpTest\Interfaces\RepositoryInterface;

class ScheduleRepository implements RepositoryInterface
{
    public function __construct(
        private ScheduleStorage $storage,
        private FactoryInterface $factory
    ) {
    }

    /**
     * @throws StorageDataMissingException
     */
    public function getById(int $id):EntityInterface
    {
        $data = $this->storage->getById($id);

        if (empty($data)) {
            throw new StorageDataMissingException();
        }

        return $this->factory->createEntity($data);
    }

    public function getByIds(array $ids): CollectionInterface
    {
        // TODO: Implement getByIds() method.
    }
}
