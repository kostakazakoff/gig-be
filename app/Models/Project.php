<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'translation_group',
        'translation_key',
        'price',
        'date',
    ];

    protected $appends = ['title', 'description', 'image_src'];

    public function getTitleAttribute()
    {
        return __($this->translation_group . '.' . $this->translation_key . '.title');
    }

    public function getDescriptionAttribute()
    {
        return __($this->translation_group . '.' . $this->translation_key . '.description');
    }

    public function getImageSrcAttribute(): ?string
    {
        $media = $this->getFirstMedia('project_images');
        return $media ? $media->getUrl() : null;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('project_images')
            ->useFallbackUrl('/GIG_960x480.jpg')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp']);
    }
}
