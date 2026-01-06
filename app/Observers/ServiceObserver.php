<?php

namespace App\Observers;

use App\Models\Service;
use Spatie\TranslationLoader\LanguageLine;

class ServiceObserver
{
    /**
     * Handle the Service "created" event.
     */
    public function created(Service $service): void
    {
        //
    }

    /**
     * Handle the Service "updated" event.
     */
    public function updated(Service $service): void
    {
        //
    }

    /**
     * Handle the Service "deleted" event.
     */
    public function deleting(Service $service): void
    {        
        // Delete language lines for this service
        LanguageLine::where('group', $service->translation_group)
            ->whereIn('key', [
                "{$service->translation_key}.name",
                "{$service->translation_key}.description",
            ])
            ->delete();
        
        cache()->forget('spatie.translation-loader');
    }

    /**
     * Handle the Service "restored" event.
     */
    public function restored(Service $service): void
    {
        //
    }

    /**
     * Handle the Service "force deleted" event.
     */
    public function forceDeleted(Service $service): void
    {        
        // Delete language lines for this service
        LanguageLine::where('group', $service->translation_group)
            ->whereIn('key', [
                "{$service->translation_key}.name",
                "{$service->translation_key}.description",
            ])
            ->delete();
        
        cache()->forget('spatie.translation-loader');
    }
}
