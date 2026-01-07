<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['translation_group', 'translation_key'];

    protected $appends = ['name', 'description', 'image_src'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('category_thumbs')
            ->useFallbackUrl('/GIG_960x480.jpg')
            ->acceptsMimeTypes(['image/jpeg',  'image/jpg', 'image/png', 'image/webp'])
            ->singleFile();
    }

    public function getImageSrcAttribute(): ?string
    {
        $media = $this->getFirstMedia('category_thumbs');
        return $media ? $media->getUrl() : null;
    }

    public function getNameAttribute(): string
    {
        return __(
            "{$this->translation_group}.{$this->translation_key}.name"
        );
    }

    public function getDescriptionAttribute(): string
    {
        return __(
            "{$this->translation_group}.{$this->translation_key}.description"
        );
    }

    /**
     * Get translation for a specific language
     */
    public function getTranslation(string $key, string $locale = 'en'): ?string
    {
        $line = \Spatie\TranslationLoader\LanguageLine::where([
            'group' => $this->translation_group,
            'key' => "{$this->translation_key}.{$key}",
        ])->first();

        if (!$line) {
            return null;
        }

        return $line->text[$locale] ?? null;
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
