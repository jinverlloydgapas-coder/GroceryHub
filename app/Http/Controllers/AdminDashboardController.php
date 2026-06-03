<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        // Get statistics
        $totalUsers = \App\Models\User::count();
        $totalItems = Task::count();
        $totalBought = Task::where('status', 'bought')->count();
        $totalPending = Task::where('status', 'pending')->count();

        // Get most bought items (public catalog)
        $mostBoughtItems = Task::whereNull('user_id')
            ->where('status', 'bought')
            ->selectRaw('title, COUNT(*) as purchase_count')
            ->groupBy('title')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(10)
            ->get();

        // Get least bought items (public catalog)
        $leastBoughtItems = Task::whereNull('user_id')
            ->whereIn('id', function($query) {
                $query->selectRaw('MIN(id)')
                    ->from('tasks')
                    ->whereNull('user_id')
                    ->groupBy('title');
            })
            ->select('title', 'quantity', 'unit', 'status')
            ->orderBy('title')
            ->limit(10)
            ->get();

        // Get top customers (users with most items bought)
        $topCustomers = \App\Models\User::where('role', 'user')
            ->withCount(['tasks as bought_count' => function($query) {
                $query->where('status', 'bought');
            }])
            ->orderByDesc('bought_count')
            ->limit(5)
            ->get();

        // Get recent activities
        $recentActivities = Task::with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalItems' => $totalItems,
            'totalBought' => $totalBought,
            'totalPending' => $totalPending,
            'mostBoughtItems' => $mostBoughtItems,
            'leastBoughtItems' => $leastBoughtItems,
            'topCustomers' => $topCustomers,
            'recentActivities' => $recentActivities,
        ]);
    }
}
