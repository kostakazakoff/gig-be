<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\AppServices\Project\IndexProjects;
use App\AppServices\Project\StoreProject;
use App\AppServices\Project\UpdateProject;
use App\AppServices\Project\DestroyProject;
use App\Traits\HttpResponses;

class ProjectController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(IndexProjects $indexProjects)
    {
        $projects = $indexProjects->handle();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request, StoreProject $storeProject)
    {
        $storeProject->handle($request->validated());

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project, UpdateProject $updateProject)
    {
        $updateProject->handle($project, $request->validated());

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, DestroyProject $destroyProject)
    {
        $destroyProject->handle($project);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully');
    }

    /**
     * Delete a specific media item from a project
     */
    public function deleteMedia(Project $project, $mediaId)
    {
        $media = $project->getMedia('project_images')->where('id', $mediaId)->first();
        
        if ($media) {
            $media->delete();
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Image not found'
        ], 404);
    }
}
