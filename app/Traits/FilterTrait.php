<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

trait FilterTrait
{
    protected function filter(Builder $query, Request $request): void
    {
        $model = $query->getModel();

        foreach ($request->query() as $key => $value) {
            if ($key === 'page' || !$request->filled($key)) {
                continue;
            }

            if ($this->columnExistsOnModel($model, $key)) {
                // Campo direto do model
                if ($this->isDateCast($model, $key)) {
                    $this->handleDateFilter($query, $key, $value);
                } elseif ($this->isIdColumn($key)) {
                    $query->where($key, $value);
                } else {
                    $this->handleColumnFilter($query, $key, $value);
                }
            } elseif ($this->isRelationFilter($key)) {
                // Campo relacionado
                [$relation, $field] = $this->parseRelationAndField($key);

                if (method_exists($model, $relation)) {
                    $this->applySubqueryFilter($query, $relation, $field, $value);
                }
            }
        }
    }

    private function isRelationFilter(string $key): bool
    {
        return strpos($key, '_') !== false;
    }

    private function isDateCast($model, string $column): bool
    {
        return $model->hasCast($column, [
            'date', 'datetime', 'timestamp', 'immutable_date', 'immutable_datetime'
        ]);
    }

    private function isIdColumn(string $column): bool
    {
        return $column === 'id' || str_ends_with($column, '_id');
    }

    private function handleDateFilter(Builder $query, string $column, string $value): void
    {
        $date = Carbon::parse($value)->format('Y-m-d');
        $query->whereDate($column, $date);
    }

    private function handleColumnFilter(Builder $query, string $column, string $value): void
    {
        $query->where($column, 'like', "%{$value}%");
    }

    private function parseRelationAndField(string $key): array
    {
        $parts = explode('_', $key);
        $relation = array_shift($parts);
        $field = implode('_', $parts);

        return [$relation, $field];
    }

    private function columnExistsOnModel($model, string $column): bool
    {
        return in_array($column, $model->getFillable()) ||
               array_key_exists($column, $model->getAttributes()) ||
               array_key_exists($column, $model->getCasts());
    }

    private function applyColumnFilter(Builder $query, string $column, string $value): void
    {
        $query->where($column, 'like', "%{$value}%");
    }

    private function applySubqueryFilter(Builder $query, string $relation, string $relationKey, string $value): void
    {
        $query->whereHas($relation, function ($subQuery) use ($relationKey, $value) {
            $model = $subQuery->getModel();

            if ($this->isDateCast($model, $relationKey)) {
                $this->handleDateFilter($subQuery, $relationKey, $value);
            } elseif ($this->isIdColumn($relationKey)) {
                $subQuery->where($relationKey, $value);
            } else {
                $subQuery->where($relationKey, 'like', "%{$value}%");
            }
        });
    }
}
