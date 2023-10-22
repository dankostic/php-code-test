<?php
declare(strict_types=1);

namespace Tests;

use Codeception\Example;
use JetBrains\PhpStorm\ArrayShape;
use Mockery;
use Mockery\MockInterface;
use Tymeshift\PhpTest\Components\DatabaseInterface;
use Tymeshift\PhpTest\Components\HttpClientInterface;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleEntity;
use Tymeshift\PhpTest\Domains\Schedule\ScheduleStorage;
use Tymeshift\PhpTest\Domains\Task\TaskStorage;
use Tymeshift\PhpTest\Exceptions\StorageDataMissingException;
use Tymeshift\PhpTest\Factories\ScheduleFactory;
use Tymeshift\PhpTest\Factories\ScheduleItemFactory;
use Tymeshift\PhpTest\Factories\TaskFactory;
use Tymeshift\PhpTest\Interfaces\EntityInterface;
use Tymeshift\PhpTest\Providers\TaskProvider;
use Tymeshift\PhpTest\Repositories\ScheduleRepository;
use Tymeshift\PhpTest\Repositories\TaskRepository;
use Tymeshift\PhpTest\Services\ScheduleService;
use UnitTester;

class ScheduleItemCest
{
    /**
     * @var MockInterface|HttpClientInterface
     */
    private $httpClientMock;

    /**
     * @var MockInterface|DatabaseInterface
     */
    private $database;

    /**
     * @var ScheduleRepository
     */
    private $scheduleRepository;

    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * @var ScheduleService
     */
    private $scheduleService;


    public function _before()
    {
        $this->httpClientMock = Mockery::mock(HttpClientInterface::class);
        $this->database = Mockery::mock(DatabaseInterface::class);
        $this->scheduleRepository = new ScheduleRepository(new ScheduleStorage($this->database), new ScheduleFactory());
        $this->taskRepository = new TaskRepository(new TaskStorage($this->httpClientMock), new TaskFactory());
        $this->scheduleService = new ScheduleService($this->scheduleRepository, $this->taskRepository, new ScheduleItemFactory());
    }

    public function _after()
    {
        $this->httpClientMock = null;
        $this->database = null;
        $this->taskRepository = null;
        $this->scheduleRepository = null;
        $this->scheduleService = null;
        Mockery::close();
    }

    /**
     * @dataProvider tasksDataProvider
     * @throws StorageDataMissingException
     */
    public function testAddScheduleEntityItemsSuccess(Example $example, UnitTester $tester): void
    {
        $this->httpClientMock
            ->shouldReceive('request')
            ->with(TaskProvider::GET, '/api/tasks/schedule/1')
            ->andReturn([...$example]);

        $this->database
            ->shouldReceive('query')
            ->with('SELECT * FROM schedules WHERE id=:id', [ "id" => 1 ])
            ->andReturn($this->databaseQuery());

        /** @var ScheduleEntity $schedule */
        $schedule = $this->scheduleService->addScheduleEntityItems(1);

        $tester->assertEquals(1, $schedule->getId());
        $tester->assertEquals(1, $schedule->getItems()[0]->getScheduleId());
        $tester->assertEquals(strtotime('NOW'), $schedule->getItems()[0]->getStartTime());
        $tester->assertEquals(3600, $schedule->getItems()[1]->getStartTime());
        $tester->assertEquals(9200, $schedule->getItems()[2]->getEndTime());
        $tester->assertEquals('Schedule', $schedule->getItems()[0]->getType());
        $tester->assertInstanceOf(EntityInterface::class, $schedule);
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

    #[ArrayShape(['id' => "int", 'start_time' => "int", 'end_time' => "int", 'name' => "string"])]
    private function databaseQuery(): array
    {
        return [ 'id' => 1, 'start_time' => 1631232000, 'end_time' => 1631232000 + 86400, 'name' => 'Test' ];
    }
}
