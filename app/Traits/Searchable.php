<?php

namespace App\Traits;

trait Searchable
{
    public function scopeSearch($query, $search, array $fields)
    {
        return $query->where(function($query) use ($search, $fields) {
            foreach ($fields as $field) {
                if (str_contains($field, '.')) {
                    $relations = explode('.', $field);
                    $relatedField = array_pop($relations);
                    $relationPath = implode('.', $relations);

                    $query->orWhereHas($relationPath, function($query) use ($relatedField, $search) {
                        $query->where($relatedField, 'like', "%{$search}%");
                    });
                } else {
                    $query->orWhere($field, 'like', "%{$search}%");
                }
            }
        });

    }
}

