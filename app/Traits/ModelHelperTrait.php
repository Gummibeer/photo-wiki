<?php

namespace App\Traits;

use App\Models\Model;

trait ModelHelperTrait
{
    public static function getTableName($relation = null, $as = null)
    {
        $that = (new static);
        if (is_null($relation)) {
            if (! is_null($as)) {
                return $that->getTable().' AS '.str_slug($as, Model::SLUG_SEPERATOR);
            } else {
                return $that->getTable();
            }
        } else {
            if (method_exists($that, $relation)) {
                if (method_exists($that->{$relation}(), 'getTable')) {
                    return $that->{$relation}()->getTable();
                }

                return $that->{$relation}()->getRelated()->getTable();
            } else {
                throw new \BadMethodCallException("There is no {$relation}() method in {$that}");
            }
        }
    }

    public static function getFillableFields(array $appends = [], array $remove = [])
    {
        $model = (new static);

        return array_diff(array_merge($model->getFillable(), $appends), $remove);
    }
}
