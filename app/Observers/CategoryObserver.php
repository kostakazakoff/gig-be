<?php

namespace App\Observers;

use App\Models\Category;
use Spatie\TranslationLoader\LanguageLine;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        // Delete all associated services one by one to trigger their delete events
        // Spatie Media Library and Translation Loader will automatically clean up their data
        $category->services()->each(function ($service) {
            $service->delete();
        });
        
        // Delete category language lines
        LanguageLine::where('group', $category->translation_group)->delete();
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        // Force delete all associated services one by one to trigger their delete events
        // Spatie Media Library and Translation Loader will automatically clean up their data
        $category->services()->each(function ($service) {
            $service->forceDelete();
        });
        
        // Delete category language lines
        LanguageLine::where('group', $category->translation_group)->delete();
    }
}
