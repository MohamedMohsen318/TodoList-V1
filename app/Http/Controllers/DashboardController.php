<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\Admin;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();

            return view('admin.dashboard', [
                'admin' => $admin,
                'stats' => [
                    'users' => User::count(),
                    'admins' => Admin::count(),
                    'tasks' => Tasks::count(),
                    'completed_tasks' => Tasks::where('status', 'completed')->count(),
                ],
            ]);
        }

        $user = Auth::guard('web')->user();
        $query = Tasks::where('user_id', $user->id);

        return view('user.dashboard', [
            'user' => $user,
            'stats' => [
                'all' => (clone $query)->count(),
                'pending' => (clone $query)->where('status', TaskStatus::Pending->value)->count(),
                'in_progress' => (clone $query)->where('status', TaskStatus::InProgress->value)->count(),
                'completed' => (clone $query)->where('status', TaskStatus::Completed->value)->count(),
            ],
        ]);
    }
}
