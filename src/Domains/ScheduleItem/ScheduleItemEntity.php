<?php

namespace Tymeshift\PhpTest\Domains\ScheduleItem;

use Tymeshift\PhpTest\Interfaces\ScheduleItemInterface;

class ScheduleItemEntity implements ScheduleItemInterface
{
    /**
     * @var int
     */
    private int $scheduleId;
    /**
     * @var int
     */
    private int $startTime;
    /**
     * @var int
     */
    private int $endTime;
    /**
     * @var string
     */
    private string $type;

    /**
     * @return int
     */
    public function getScheduleId(): int
    {
        return $this->scheduleId;
    }

    /**
     * @param int $scheduleId
     * @return $this
     */
    public function setScheduleId(int $scheduleId): self
    {
        $this->scheduleId = $scheduleId;

        return $this;
    }

    /**
     * @return int
     */
    public function getStartTime(): int
    {
        return $this->startTime;
    }

    /**
     * @param int $startTime
     * @return $this
     */
    public function setStartTime(int $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * @return int
     */
    public function getEndTime(): int
    {
        return $this->endTime;
    }

    /**
     * @param int $endTime
     * @return $this
     */
    public function setEndTime(int $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
