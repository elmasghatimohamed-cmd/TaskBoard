<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::latest()->paginate(5);
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
        Task::create($validated);
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
        $tasks = Task::onlyTrashed()->get();
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
        $stats = [
            'total' => Task::count(),
            'todo' => Task::where('status', 'todo')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'done' => Task::where('status', 'done')->count(),
            'high_priority' => Task::where('priority', 'high')->count(),
            'overdue' => Task::where('deadline', '<', now())->where('status', '!=', 'done')->count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
