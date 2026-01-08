<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class News extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'translation_group',
        'translation_key',
    ];

    protected $appends = ['image_src', 'title', 'content'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('news_thumbs')
            ->useFallbackUrl('/GIG_960x480.jpg')
            ->acceptsMimeTypes(['image/jpeg',  'image/jpg', 'image/png', 'image/webp'])
            ->singleFile();
    }

    public function getImageSrcAttribute(): ?string
    {
        $media = $this->getFirstMedia('news_thumbs');
        return $media ? $media->getUrl() : null;
    }

    public function getTitleAttribute(): string
    {
        return __(
            "{$this->translation_group}.{$this->translation_key}.title"
        );
    }

    public function getContentAttribute(): string
    {
        return __(
            "{$this->translation_group}.{$this->translation_key}.content"
        );
    }

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
}
