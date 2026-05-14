<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Tasks extends Model
{
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'status',
        'user_id',
        'parent_id',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Tasks::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Tasks::class, 'parent_id');
    }

    public function Allchildren(): HasMany
    {
        return $this->children()->with('Allchildren');
    }
}
