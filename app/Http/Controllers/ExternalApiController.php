<?php

namespace App\Http\Controllers;

use App\Services\ExternalTaskService;
use Illuminate\Http\Request;

class ExternalApiController extends Controller
{
    protected ExternalTaskService $taskService;

    public function __construct(ExternalTaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        return response()->json($this->taskService->getExternalTasks());
    }

    public function show($id)
    {
        $task = $this->taskService->getExternalTaskById($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'completed' => 'boolean',
            'userId' => 'integer',
        ]);

        $result = $this->taskService->sendTaskData($validated);

        return response()->json($result, 201);
    }
}