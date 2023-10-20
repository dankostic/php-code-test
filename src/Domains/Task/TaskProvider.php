<?php

namespace Tymeshift\PhpTest\Domains\Task;

class TaskProvider
{
    public const GET = 'GET';
    private const API_URL = '/api/tasks/';

    private const API_TASK = '/api/task/';
    private const SCHEDULE = 'schedule/';

    protected function getSingleTask(int $id): string
    {
        return self::API_TASK . $id;
    }

    protected function getSingleTaskFromSchedule(int $id): string
    {
        return self::API_URL . self::SCHEDULE . $id;
    }

    protected function getTasksByIds(array $ids): string
    {
        return self::API_URL . implode(',', $ids);
    }
}