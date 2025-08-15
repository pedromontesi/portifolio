<?php

namespace App\Http\Controllers;

use App\Services\GitHubService;

class PortfolioController extends Controller
{
    protected GitHubService $github;

    public function __construct(GitHubService $github)
    {
        $this->github = $github;
    }

    public function index()
    {
        $repos = $this->github->getRecentRepos(14);
        return view('portfolio', compact('repos'));
    }
}
