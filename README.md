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
