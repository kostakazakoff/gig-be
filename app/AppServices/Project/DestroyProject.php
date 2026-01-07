<?php

namespace App\AppServices\Project;

use App\Models\Project;

class DestroyProject
{
    public function handle(Project $project): void
    {
        // Media files will be automatically deleted by Spatie Media Library
        $project->delete();
    }
}
