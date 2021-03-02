<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class State extends Model
{
    protected $table = 'state';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * Scope to filter by id
     * @param Builder $query
     * @param ?string $id
     * @return Builder $query
     */
    public function scopeFilterById(Builder $query, ?string $id) : Builder
    {
        if (!empty($id)) {
            $query->where('id', $id);
        }

        return $query;
    }

    /**
     * Scope to filter by name
     * @param Builder $query
     * @param string $name
     * @return Builder $query
     */
    public function scopeFilterByName(Builder $query, string $name) : Builder
    {
        return $query->where('name', $name);
    }

    /**
     * Scope to filter by abbreviation
     * @param Builder $query
     * @param string $abbreviation
     * @return Builder $query
     */
    public function scopeFilterByAbbreviation(Builder $query, string $abbreviation) : Builder
    {
        return $query->where('abbreviation', $abbreviation);
    }
}
