<?php

namespace Tymeshift\PhpTest\Providers;

class TaskProvider
{
    public const GET = 'GET';
    private const API_URL = '/api/tasks/';
    private const SCHEDULE = 'schedule/';

    protected function getSingleTask(int $id): string
    {
        return self::API_URL . $id;
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
