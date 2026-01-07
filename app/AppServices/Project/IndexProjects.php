<?php

namespace App\AppServices\Project;

use App\Models\Project;

class IndexProjects
{
    public function handle()
    {
        return Project::latest()->get();
    }
}
