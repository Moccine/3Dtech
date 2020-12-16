<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class TaskManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function start(string $command, string $logFile): Task
    {
        $task = new Task();

        $task->setCommand($command);
        $task->setExecutedAt(new \DateTime());
        $task->setLogFile($logFile);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }

    public function completed(Task $task): void
    {
        $task->setTerminatedAt(new \DateTime());

        $this->entityManager->flush();
    }
}
