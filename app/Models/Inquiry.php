<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use Filterable;
    
    protected $fillable = [
        'client_id',
        'category_id',
        'message',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}