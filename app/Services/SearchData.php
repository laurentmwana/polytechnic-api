<?php

namespace App\Services;

use App\Exceptions\SearchDataFieldsEmptyException;
use Illuminate\Database\Eloquent\Builder;

abstract class SearchData
{

    public static function handle(Builder $builder, string $queryValue, array $fields): Builder
    {
        if (empty($fields)) {
            throw new SearchDataFieldsEmptyException();
        }

        return $builder->where(function ($q) use ($queryValue, $fields) {
            foreach ($fields as $key => $field) {
                if ($key === 0) {
                    $q->whereLike($field, "%$queryValue%");
                } else {
                    $q->orWhereLike($field, "%$queryValue%");
                }
            }
        });
    }
}
