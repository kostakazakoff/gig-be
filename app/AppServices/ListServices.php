<?php

namespace App\AppServices;

use App\Models\Service;

class ListServices
{
    public function handle($categoryId)
    {
        $services = Service::
        whereCategoryId($categoryId)
        ->with('category', 'unit')
        ->get();

        return $services;
    }
}
