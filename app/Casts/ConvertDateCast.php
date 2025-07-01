<?php

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ConvertDateCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!$value) {
            return null;
        }

        return Carbon::parse($value)
            ->setTimezone('America/Sao_Paulo')
            ->format('d/m/Y H:i');
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!$value) {
            return null;
        }

        return Carbon::parse($value)->setTimezone('America/Sao_Paulo');
    }
}
