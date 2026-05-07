<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $table = 'tasks';
    protected $fillable = ['title', 'description', 'deadline', 'status', 'user_id'];

    protected $casts = [
        'status' => TaskStatus::class,
    ];

}
