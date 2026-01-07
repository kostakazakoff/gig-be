<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

trait OptimizesImages
{
    // composer require intervention/image
    /**
     * Resize и оптимизира изображение преди upload
     */
    protected function optimizeImage(UploadedFile $file, int $maxWidth, int $maxHeight, int $quality = 85): UploadedFile
    {
        $manager = new ImageManager(new Driver());
        
        $image = $manager->read($file->getRealPath());
        
        // Resize с запазване на пропорциите
        $image->scale(width: $maxWidth, height: $maxHeight);
        
        // Създай временен файл
        $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Запази оптимизираното изображение
        if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg'])) {
            $image->toJpeg($quality)->save($tempPath);
        } elseif ($file->getClientOriginalExtension() === 'png') {
            $image->toPng()->save($tempPath);
        } elseif ($file->getClientOriginalExtension() === 'webp') {
            $image->toWebp($quality)->save($tempPath);
        } else {
            $image->save($tempPath);
        }
        
        // Създай нов UploadedFile от оптимизираното изображение
        return new UploadedFile(
            $tempPath,
            $file->getClientOriginalName(),
            $file->getClientMimeType(),
            null,
            true
        );
    }
}
