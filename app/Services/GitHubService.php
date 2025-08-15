<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GitHubService
{
    protected string $user = 'pedromontesi';

    public function getRecentRepos(int $limit = 8): array
    {
        $response = Http::withToken(env('GITHUB_TOKEN'))
            ->get("https://api.github.com/users/{$this->user}/repos", [
                'sort' => 'created',
                'per_page' => $limit
            ]);

        return $response->json();
    }
}
