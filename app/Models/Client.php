<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Client extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'company',
        'language',
        'site',
    ];

    protected $appends = [
        'image_src',
    ];

    public function getImageSrcAttribute()
    {
        $media = $this->getFirstMedia('client_avatars');
        return $media ? $media->getUrl() : null;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('client_avatars')
            ->acceptsMimeTypes(['image/jpeg',  'image/jpg', 'image/png', 'image/webp'])
            ->singleFile();
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }
}
