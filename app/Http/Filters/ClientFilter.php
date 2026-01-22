<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ClientFilter extends Filter
{
    /**
     * Filter clients by search field and search value.
     *
     * @param  string|null  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function search(?string $value = null): Builder
    {
        if (! $value) {
            return $this->builder;
        }

        $searchField = $this->request->get('search_field', 'name');

        return match($searchField) {
            'name' => $this->builder->where(function($query) use ($value) {
                $query->where('first_name', 'like', "%{$value}%")
                      ->orWhere('last_name', 'like', "%{$value}%")
                      ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$value}%"]);
            }),
            'email' => $this->builder->where('email', 'like', "%{$value}%"),
            'phone' => $this->builder->where('phone', 'like', "%{$value}%"),
            'company' => $this->builder->where('company', 'like', "%{$value}%"),
            default => $this->builder,
        };
    }

    /**
     * Filter by search field (this method is called automatically but we don't need to do anything)
     * The actual filtering is done in the search() method above.
     *
     * @param  string|null  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function search_field(?string $value = null): Builder
    {
        // This method is called automatically by the Filter base class
        // but we don't need to do anything here since search_field is handled in search()
        return $this->builder;
    }
}
