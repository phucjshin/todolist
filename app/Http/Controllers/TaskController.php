<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderByRaw("status = 'pending' ASC") // pending xếp cuối
             ->orderBy('created_at', 'desc')       // sắp xếp theo ngày tạo
             ->get();

        return view('index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        Task::create(['title' => $request->title]);
        return redirect()->back()->with('success', 'Task added!');
    }

    public function updateStatus(Task $task)
    {
        $task->update(['completed' => !$task->completed]);
        return redirect()->back();
    }

    public function updateTitle(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $task->update(['title' => $request->title]);
        return redirect('/')->with('success', 'Task updated!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back();
    }
    
    public function pending($id) {
        $task = Task::findOrFail($id);
        $task->status = $task->status === 'pending' ? 'active' : 'pending';
        $task->save();
        return redirect()->back();
    }


}
