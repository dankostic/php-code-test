<?php

namespace Tymeshift\PhpTest\Factories;

use Tymeshift\PhpTest\Domains\ScheduleItem\ScheduleItemEntity;
use Tymeshift\PhpTest\Domains\Task\TaskEntity;
use Tymeshift\PhpTest\Interfaces\ScheduleItemInterface;

class ScheduleItemFactory
{
    /**
     * @param TaskEntity $data
     * @return ScheduleItemInterface
     */
    public function createEntity(TaskEntity $data): ScheduleItemInterface
    {
        $scheduleItem = new ScheduleItemEntity();

        return $scheduleItem
            ->setScheduleId($data->getScheduleId())
            ->setStartTime($data->getStartTime()->format('U'))
            ->setEndTime($data->getStartTime()->format('U') + $data->getDuration()->format('U'))
            ->setType('Schedule');
    }
}
