<?php

namespace App\AppServices\Project;

use App\Models\Project;
use App\Traits\Translates;

class UpdateProject
{
    use Translates;

    public function handle(Project $project, array $data): Project
    {
        // Update project fields
        $project->update([
            'price' => $data['price'] ?? null,
            'date' => $data['date'] ?? null,
        ]);

        $this->updateTranslation($project, $data, ['title', 'description']);

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
