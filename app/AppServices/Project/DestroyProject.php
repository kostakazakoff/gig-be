<?php

namespace App\AppServices\Project;

use App\Models\Project;

class DestroyProject
{
    public function handle(Project $project): void
    {
        $project->delete();
    }
}
