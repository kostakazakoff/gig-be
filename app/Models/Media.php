<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    protected function previewUrl(): Attribute
    {
        return Attribute::get(
            fn () => $this->hasGeneratedConversion('project_thumb') 
                ? $this->getUrl('project_thumb') 
                : ''
        );
    }
}
