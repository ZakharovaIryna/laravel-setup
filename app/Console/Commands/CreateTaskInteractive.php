<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateTaskInteractive extends Command
{
    protected $signature = 'tasks:create-interactive';

    public function handle()
    {
    $title = $this->ask('Введіть назву завдання');
    $description = $this->ask('Введіть опис');
    $projectId = $this->ask('Введіть ID проєкту');
    $due_date = $this->ask('Введіть дедлайн (наприклад, YYYY-MM-DD)');
    $authorId = $this->ask('Введіть ID автора');

    $status = $this->choice('Оберіть статус', ['new', 'in_progress', 'done'], 0);

    if ($this->confirm('Зберегти нове завдання?')) {
        $task = \App\Models\Task::create([
            'title' => $title,
            'description' => $description,
            'project_id' => $projectId,
            'due_date' => $due_date,
            'author_id' => $authorId,
            'status' => $status,
        ]);

        $this->info("Успішно створено завдання з ID: {$task->id}");
    } else {
        $this->warn('Створення скасовано.');
    }
    }
}
