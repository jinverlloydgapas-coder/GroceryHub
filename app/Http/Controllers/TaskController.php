<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit' => ['required', 'string', 'max:50'],
            'status' => ['required', 'in:pending,bought'],
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'notes' => $validated['notes'],
            'quantity' => $validated['quantity'],
            'unit' => $validated['unit'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('tasks.index')->with('success', 'Grocery item added successfully.');
    }

    public function edit(Task $task)
    {
        abort_unless($task->user_id === Auth::id(), 403);

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        abort_unless($task->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit' => ['required', 'string', 'max:50'],
            'status' => ['required', 'in:pending,bought'],
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Grocery item updated successfully.');
    }

    public function destroy(Task $task)
    {
        abort_unless($task->user_id === Auth::id(), 403);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Grocery item deleted successfully.');
    }

    public function toggleStatus(Task $task)
    {
        abort_unless($task->user_id === Auth::id(), 403);

        $newStatus = $task->status === 'pending' ? 'bought' : 'pending';
        $task->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'message' => 'Item marked as ' . $newStatus
        ]);
    }

    public function addFromCatalog(Request $request, Task $task)
    {
        // Get the catalog item (item with no user_id)
        abort_unless($task->user_id === null, 403);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        // Create a new task for the authenticated user based on the catalog item
        Task::create([
            'user_id' => Auth::id(),
            'title' => $task->title,
            'notes' => $task->notes,
            'quantity' => $validated['quantity'],
            'unit' => $task->unit,
            'status' => 'pending',
        ]);

        return redirect()->route('home')->with('success', $task->title . ' added to your grocery list!');
    }
}
