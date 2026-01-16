<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ServiceFilter extends Filter
{
    /**
     * Filter the services by the given category.
     *
     * @param  string|null  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function category(?string $value = null): Builder
    {
        if (! $value) {
            return $this->builder;
        }
        return $this->builder->where('category_id', $value);
    }
}
