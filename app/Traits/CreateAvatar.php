<?php

namespace App\Traits;

trait CreateAvatar
{
    use OptimizesImages;

    public function createAvatar($model, array $images, string $collectionName): void
    {
        foreach ($images as $image) {
            $optimizedImage = $this->optimizeImage($image, 48, 48);

            $model  ->addMedia($optimizedImage)
                    ->toMediaCollection($collectionName);
        }
    }
}
