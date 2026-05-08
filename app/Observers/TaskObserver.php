<?php

namespace App\Observers;

use App\Enums\TaskStatus;
use App\Models\Tasks;
use App\Services\SlackNotifier;

class TaskObserver
{
    public function __construct(private readonly SlackNotifier $slackNotifier)
    {
    }

    public function created(Tasks $task): void
    {
        $this->slackNotifier->sendTaskCreated($task, $this->actorName());
    }

    public function updated(Tasks $task): void
    {
        if (
            $task->wasChanged('status')
            && $task->status === TaskStatus::Completed
            && $task->getOriginal('status') !== TaskStatus::Completed->value
        ) {
            $this->slackNotifier->sendTaskCompleted($task, $this->actorName());
        }
    }

    public function deleted(Tasks $task): void
    {
        $this->slackNotifier->sendTaskDeleted($task, $this->actorName());
    }

    private function actorName(): string
    {
        return (string) (auth()->user()?->name ?? 'System');
    }
}
