<?php

namespace App\Http\Controllers\Api;

use App\AppServices\Project\IndexProjects;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Traits\HttpResponses;

class ProjectController extends Controller
{
    use HttpResponses;
    
    public function index(IndexProjects $indexProjects): \Illuminate\Http\JsonResponse
    {
        $projects = $indexProjects->handle();
        return $this->success($projects, 'Projects retrieved successfully');
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $project = Project::findOrFail($id);
        return $this->success($project, __('messages.project_retrieved_successfully'));
    }
}
