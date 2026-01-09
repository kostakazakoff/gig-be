<?php

namespace App\Traits;

trait CreateThumbnail
{
    use OptimizesImages;

    public function createThumbnail($model, array $images, string $collectionName): void
    {
        foreach ($images as $image) {
            $optimizedImage = $this->optimizeImage($image, 480, 360);

            $model  ->addMedia($optimizedImage)
                    ->toMediaCollection($collectionName);
        }
    }
}