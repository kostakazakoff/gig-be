<?php

namespace App\AppServices\Project;

use App\Models\Project;
use App\Traits\Translates;
use Spatie\TranslationLoader\LanguageLine;

class StoreProject
{
    use Translates;
    public function handle(array $data): Project
    {
        $project = Project::create([
            'translation_group' => 'projects_' . $data['key'],
            'translation_key' => $data['key'],
            'price' => $data['price'] ?? null,
            'date' => $data['date'] ?? null,
        ]);

        $this->translate($project, $data, ['title', 'description']);

        // Handle multiple images
        if (!empty($data['images'])) {
            foreach ($data['images'] as $image) {
                $project->addMedia($image)
                    ->toMediaCollection('project_images');
            }
        }

        return $project;
    }
}
