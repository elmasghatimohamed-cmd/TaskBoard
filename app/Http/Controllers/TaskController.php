<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = auth()->user()->tasks()->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validateWithBag('taskCreation', [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,done',
        ]);
        auth()->user()->tasks()->create($validated);
        return redirect()->route('tasks.index')->with('status', 'task created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée');
        }

        $validated = $request->validateWithBag('taskUpdate', [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('status', 'Task updated successfully');
    }

    /**
     * Applying soft delete using the tait softDeletes()
     */

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('status', 'Task archived successfully');

    }

    /**
     * Display archived tasks
     */
    public function archived()
    {
        $tasks = auth()->user()->tasks()->onlyTrashed()->get();
        return view('tasks.archived', compact('tasks'));
    }

    /**
     * Restore an archived task
     */
    public function restore($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->restore();

        return redirect()->route('tasks.archived')->with('status', 'Task restored successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function forceDestroy($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->forceDelete();

        return redirect()->route('tasks.archived')->with('status', 'Task permanently deleted');
    }


    public function dashboard()
    {
        $user = auth()->user();

        $priorityCounts = $user->tasks()
            ->selectRaw('priority, count(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();
        $stats = [
            'total' => $user->tasks()->count(),
            'todo' => $user->tasks()->where('status', 'todo')->count(),
            'in_progress' => $user->tasks()->where('status', 'in_progress')->count(),
            'done' => $user->tasks()->where('status', 'done')->count(),
            'overdue' => $user->tasks()->where('deadline', '<', now())
                ->where('status', '!=', 'done')->count(),
            'high_priority' => $priorityCounts['high'] ?? 0,
            'medium_priority' => $priorityCounts['medium'] ?? 0,
            'low_priority' => $priorityCounts['low'] ?? 0,
        ];
        return view('dashboard', compact('stats'));
    }

    public function action(Request $request)
    {
        $query = $request->get('query');
        $priority = $request->get('priority');
        $status = $request->get('status');

        $tasks = auth()->user()->tasks()
            ->when($query, function ($q) use ($query) {
                return $q->where(function ($sub) use ($query) {
                    $sub->where('title', 'like', "%$query%")
                        ->orWhere('description', 'like', "%$query%");
                });
            })
            ->when($priority, function ($q) use ($priority) {
                return $q->where('priority', $priority);
            })
            ->when($status, function ($q) use ($status) {
                return $q->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tasks.partials.task_list', compact('tasks'))->render();
    }
}


