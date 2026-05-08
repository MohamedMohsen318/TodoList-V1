<?php

namespace App\Policies;

use App\Models\Tasks;
use App\Models\User;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return $user !== null;
    }

    public function create(User $user): bool
    {
        return $user !== null;
    }

    public function update(User $user, Tasks $task): bool
    {
        return $task->user_id === $user->id;
    }

    public function delete(User $user, Tasks $task): bool
    {
        return $task->user_id === $user->id;
    }
}
