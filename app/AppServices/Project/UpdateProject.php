<?php

namespace App\AppServices\Project;

use App\Models\Project;
use Spatie\TranslationLoader\LanguageLine;

class UpdateProject
{
    public function handle(Project $project, array $data): Project
    {
        // Update project fields
        $project->update([
            'price' => $data['price'] ?? null,
            'date' => $data['date'] ?? null,
        ]);

        // Update title translations
        $titleTranslation = LanguageLine::where('group', $project->translation_group)
            ->where('key', "{$project->translation_key}.title")
            ->first();

        if ($titleTranslation) {
            $titleTranslation->setTranslation('en', $data['title_en']);
            $titleTranslation->setTranslation('bg', $data['title_bg']);
            $titleTranslation->save();
        }

        // Update description translations
        $descriptionTranslation = LanguageLine::where('group', $project->translation_group)
            ->where('key', "{$project->translation_key}.description")
            ->first();

        if ($descriptionTranslation) {
            $descriptionTranslation->setTranslation('en', $data['description_en'] ?? '');
            $descriptionTranslation->setTranslation('bg', $data['description_bg'] ?? '');
            $descriptionTranslation->save();
        }

        // Handle new images
        if (!empty($data['images'])) {
            foreach ($data['images'] as $image) {
                $project->addMedia($image)
                    ->toMediaCollection('project_images');
            }
        }

        // Reorder existing images if order provided
        if (!empty($data['media_order'])) {
            $ids = array_filter(explode(',', $data['media_order']));
            foreach ($ids as $position => $id) {
                $media = $project->getMedia('project_images')->firstWhere('id', (int) $id);
                if ($media) {
                    // Update order_column (Spatie Media Library uses this for sorting)
                    $media->order_column = $position + 1;
                    $media->save();
                }
            }
        }

        return $project;
    }
}
