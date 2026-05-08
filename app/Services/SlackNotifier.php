<?php

namespace App\Services;

use App\Models\Tasks;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SlackNotifier
{
    public function sendTaskCreated(Tasks $task, string $actorName): void
    {
        $this->sendMessage(
            "New task created by {$actorName}",
            [
                "*Title:* {$task->title}",
                "*Status:* {$task->status->value}",
                "*Deadline:* {$task->deadline}",
            ]
        );
    }

    public function sendTaskCompleted(Tasks $task, string $actorName): void
    {
        $this->sendMessage(
            "Task completed by {$actorName}",
            [
                "*Title:* {$task->title}",
                "*Status:* {$task->status->value}",
                "*Deadline:* {$task->deadline}",
            ]
        );
    }

    public function sendTaskDeleted(Tasks $task, string $actorName): void
    {
        $this->sendMessage(
            "Task deleted by {$actorName}",
            [
                "*Title:* {$task->title}",
                "*Previous status:* {$task->status->value}",
                "*Deadline:* {$task->deadline}",
            ]
        );
    }

    public function sendUserRegistered(User $user): void
    {
        $this->sendMessage(
            'New user registered',
            [
                "*Name:* {$user->name}",
                "*Email:* {$user->email}",
                "*Phone:* ".($user->phone ?: 'Not provided'),
            ]
        );
    }

    private function sendMessage(string $headline, array $details): void
    {
        $webhookUrl = config('services.slack.webhook_url');

        if (blank($webhookUrl)) {
            return;
        }

        $payload = [
            'text' => $headline,
            'username' => config('services.slack.username'),
            'channel' => config('services.slack.channel'),
            'blocks' => [
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => "*{$headline}*",
                    ],
                ],
                [
                    'type' => 'section',
                    'text' => [
                        'type' => 'mrkdwn',
                        'text' => implode("\n", $details),
                    ],
                ],
            ],
        ];

        try {
            Http::asJson()
                ->withOptions([
                    'proxy' => null,
                ])
                ->post($webhookUrl, $payload)
                ->throw();
        } catch (\Throwable $exception) {
            Log::warning('Slack notification failed.', [
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
