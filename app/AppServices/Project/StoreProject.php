<?php

namespace App\AppServices\Project;

use App\Models\Project;
use Spatie\TranslationLoader\LanguageLine;

class StoreProject
{
    public function handle(array $data): Project
    {
        $project = Project::create([
            'translation_group' => 'projects_' . $data['key'],
            'translation_key' => $data['key'],
            'price' => $data['price'] ?? null,
            'date' => $data['date'] ?? null,
        ]);

        // Create translations for title
        LanguageLine::create([
            'group' => $project->translation_group,
            'key' => "{$data['key']}.title",
            'text' => [
                'en' => $data['title_en'],
                'bg' => $data['title_bg'],
            ],
        ]);

        // Create translations for description
        LanguageLine::create([
            'group' => $project->translation_group,
            'key' => "{$data['key']}.description",
            'text' => [
                'en' => $data['description_en'] ?? '',
                'bg' => $data['description_bg'] ?? '',
            ],
        ]);

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
