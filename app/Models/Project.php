<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'translation_group',
        'translation_key',
        'price',
        'date',
    ];

    protected $appends = ['title', 'description', 'image_src', 'image_thumb_src'];

    public function getTitleAttribute()
    {
        return __($this->translation_group . '.' . $this->translation_key . '.title');
    }

    public function getDescriptionAttribute()
    {
        return __($this->translation_group . '.' . $this->translation_key . '.description');
    }

    public function getTranslation(string $field, string $locale): ?string
    {
        return __($this->translation_group . '.' . $this->translation_key . '.' . $field, [], $locale);
    }

    public function getImageSrcAttribute(): ?string
    {
        $media = $this->getFirstMedia('project_images');
        return $media ? $media->getUrl() : null;
    }

    public function getImageThumbSrcAttribute(): ?string
    {
        $media = $this->getFirstMedia('project_images');
        return $media ? $media->getUrl('project_thumb') : null;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('project_images')
            ->useFallbackUrl('/GIG_960x480.jpg')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('project_thumb')
            ->width(480)
            ->height(360)
            ->sharpen(10)
            ->nonQueued();
    }
}
