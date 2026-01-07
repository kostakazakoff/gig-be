<?php

namespace App\AppServices\Service;

use App\Models\Service;

class IndexServices
{
    public function handle()
    {
        return Service::all();
    }
}
