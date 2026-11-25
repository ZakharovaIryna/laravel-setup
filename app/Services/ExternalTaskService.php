<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalTaskService
{
    protected string $baseUrl = 'https://jsonplaceholder.typicode.com/todos';

    public function getExternalTasks()
    {
        try {
            $response = Http::timeout(5)->get($this->baseUrl);

            if ($response->successful()) {
                Log::info('Successfully fetched external tasks. Status: ' . $response->status());
                return $response->json(); 
            }

            Log::error('Failed to fetch external tasks. Status: ' . $response->status());
            return [];
        } catch (\Exception $e) {
            Log::error('Network error while fetching external tasks: ' . $e->getMessage());
            return [];
        }
    }

    public function getExternalTaskById($id)
    {
        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}/{$id}");

            if ($response->successful()) {
                Log::info("Successfully fetched task ID {$id}. Status: " . $response->status());
                return $response->json();
            }

            Log::error("Failed to fetch task ID {$id}. Status: " . $response->status());
            return null;
        } catch (\Exception $e) {
            Log::error("Network error while fetching task ID {$id}: " . $e->getMessage());
            return null;
        }
    }

    public function sendTaskData(array $data)
    {
        try {
            $response = Http::withOptions(['force_ip_v4' => true])
                ->timeout(5)
                ->post($this->baseUrl, [
                    'title' => $data['title'] ?? '',
                    'completed' => $data['completed'] ?? false,
                    'userId' => $data['userId'] ?? 1,
                ]);

            if ($response->successful()) {
                Log::info('Successfully sent task data. Status: ' . $response->status());
                return $response->json();
            }

            Log::error('Failed to send task data. Status: ' . $response->status());
            return null;
        } catch (\Exception $e) {
            Log::error('Network error while sending task data: ' . $e->getMessage());
            return null;
        }
    }
}