<?php

namespace App\AppServices;

use App\Models\Service;

class IndexServices
{
    public function handle()
    {
        return Service::all();
    }
}
