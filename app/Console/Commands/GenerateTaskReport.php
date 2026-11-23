<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateTaskReport extends Command
{
    protected $signature = 'tasks:report {--project_id=}';
    protected $description = 'Generate a report of tasks, optionally filtered by project ID';

    public function handle()
    {
    $projectId = $this->option('project_id');
    $query = \App\Models\Task::query();

    if ($projectId) {
    $query->where('project_id', $projectId);
    }
    $tasks = $query->get(['id', 'title', 'status', 'due_date']);

    if ($tasks->isEmpty()) {
        $this->warn('Завдань не знайдено.');
        return;
    }

    $this->info('Список завдань:') ;
    $this->table(
        ['ID', 'Назва', 'Статус', 'Дедлайн'],
        $tasks->toArray()
    );
    }
}
