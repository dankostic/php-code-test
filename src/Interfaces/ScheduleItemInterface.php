<?php
declare(strict_types=1);

namespace Tymeshift\PhpTest\Interfaces;

interface ScheduleItemInterface
{
    /**
     * @return int
     */
    public function getScheduleId():int;

    /**
     * @return int
     */
    public function getStartTime():int;

    /**
     * @return int
     */
    public function getEndTime():int;

    /**
     * @return string
     */
    public function getType():string;
}
