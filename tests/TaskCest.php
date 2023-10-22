<?php
declare(strict_types=1);

namespace Tests;

use Codeception\Example;
use Mockery;
use Mockery\MockInterface;
use Tymeshift\PhpTest\Components\HttpClientInterface;
use Tymeshift\PhpTest\Domains\Task\TaskCollection;
use Tymeshift\PhpTest\Domains\Task\TaskEntity;
use Tymeshift\PhpTest\Domains\Task\TaskStorage;
use Tymeshift\PhpTest\Factories\TaskFactory;
use Tymeshift\PhpTest\Providers\TaskProvider;
use Tymeshift\PhpTest\Repositories\TaskRepository;

class TaskCest
{
    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * @var MockInterface|HttpClientInterface
     */
    private $httpClientMock;


    public function _before(): void
    {
        $this->httpClientMock = Mockery::mock(HttpClientInterface::class);
        $this->taskRepository = new TaskRepository(new TaskStorage($this->httpClientMock), new TaskFactory());
    }

    public function _after(): void
    {
        $this->taskRepository = null;
        $this->httpClientMock = null;
        Mockery::close();
    }

    /**
     * @dataProvider tasksDataProvider
     */
    public function testGetTasks(Example $example, \UnitTester $tester): void
    {
        $this->httpClientMock
            ->shouldReceive('request')
            ->with(TaskProvider::GET, '/api/tasks/schedule/1')
            ->andReturn([...$example]);

        $tasks = $this->taskRepository->getByScheduleId(1);
        $tester->assertInstanceOf(TaskCollection::class, $tasks);
    }

    public function testGetTasksFailed(\UnitTester $tester): void
    {
        $tester->expectThrowable(\Exception::class, function (){
            $this->taskRepository->getByScheduleId(4);
        });
    }

    /**
     * @dataProvider tasksDataProvider
     */
    public function testGetTasksByIds(Example $example, \UnitTester $tester)
    {
        $this->httpClientMock
            ->shouldReceive('request')
            ->with(TaskProvider::GET, '/api/tasks/123,431,332')
            ->andReturn([...$example]);

        $tasks = $this->taskRepository->getByIds([123, 431, 332]);
        $tester->assertInstanceOf(TaskCollection::class, $tasks);
    }

    /**
     * @dataProvider singleTaskDataProvider
     */
    public function testGetSingleTask(Example $example, \UnitTester $tester): void
    {
        $this->httpClientMock
            ->shouldReceive('request')
            ->with(TaskProvider::GET, '/api/tasks/123')
            ->andReturn([...$example]);

        $tasks = $this->taskRepository->getById(123);
        $tester->assertInstanceOf(TaskEntity::class, $tasks);
    }

    public function tasksDataProvider(): array
    {
        return [
            [
                ["id" => 123, "schedule_id" => 1, "start_time" => 0, "duration" => 3600],
                ["id" => 431, "schedule_id" => 1, "start_time" => 3600, "duration" => 650],
                ["id" => 332, "schedule_id" => 1, "start_time" => 5600, "duration" => 3600],
            ]
        ];
    }

    public function singleTaskDataProvider(): array
    {
        return [
            [
                ["id" => 123, "schedule_id" => 1, "start_time" => 0, "duration" => 3600],
            ]
        ];
    }
}
