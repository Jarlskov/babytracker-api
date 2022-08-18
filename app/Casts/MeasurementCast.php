<?php

declare(strict_types=1);

namespace App\Casts;

use App\ValueObjects\Measurement;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use PhpUnitConversion\Unit;

class MeasurementCast implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        if (is_null($attributes['meal_amount'])) {
            return null;
        }

        return new Measurement(Unit::from($attributes['meal_amount'] . ' ' . $attributes['meal_unit']));
    }

    public function set($model, $key, $value, $attributes)
    {
        if (!$value instanceof Measurement) {
            throw new \InvalidArgumentException('The given value is not a Measurement instance.');
        }

        return [
            'meal_amount' => $value->getValue(),
            'meal_unit' => $value->getSymbol(),
        ];
    }
}
