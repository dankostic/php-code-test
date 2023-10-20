<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Domains\Task;

use Tymeshift\PhpTest\Interfaces\EntityInterface;
use DateTime;

class TaskEntity implements EntityInterface
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $scheduleId;

    /**
     * @var DateTime
     */
    private DateTime $startTime;

    /**
     * @var DateTime
     */
    private DateTime $duration;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getScheduleId(): int
    {
        return $this->scheduleId;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setScheduleId(int $scheduleId): self
    {
        $this->scheduleId = $scheduleId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    /**
     * @param DateTime $startTime
     * @return self
     */
    public function setStartTime(DateTime $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDuration(): DateTime
    {
        return $this->duration;
    }

    /**
     * @param DateTime $duration
     * @return self
     */
    public function setDuration(DateTime $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}
