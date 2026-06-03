<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $taskCount = Task::count();
        $userTasks = Task::selectRaw('user_id, count(*) as total')
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('dashboard', [
            'userCount' => $userCount,
            'taskCount' => $taskCount,
            'userTasks' => $userTasks,
            'currentUser' => Auth::user(),
        ]);
    }
}
