# TodoList-V1

Simple Laravel todo list application with authentication, task creation, task status updates, and task deletion.

## Features

- User registration and login
- Create personal tasks
- Mark tasks as completed
- Delete tasks
- Paginated task listing

## Tech Stack

- Laravel 12
- PHP 8.2
- MySQL
- Blade

## Run Locally

1. Install dependencies:

```bash
composer install
npm install
```

2. Create environment file:

```bash
cp .env.example .env
php artisan key:generate
```

3. Configure database in `.env`, then run:

```bash
php artisan migrate
```

4. Start the app:

```bash
php artisan serve
```

## Slack Integration

This project can send Slack updates when a task is created, completed, or deleted.

1. In your Slack workspace, create an `Incoming Webhook` for the channel you want.
2. Add these values to your `.env`:

```bash
SLACK_WEBHOOK_URL=https://hooks.slack.com/services/...
SLACK_CHANNEL=#your-channel-name
SLACK_BOT_USERNAME="TodoList Bot"
```

3. Clear cached config if needed:

```bash
php artisan config:clear
```
