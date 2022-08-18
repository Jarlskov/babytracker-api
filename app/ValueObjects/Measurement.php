<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use PhpUnitConversion\Unit;

class Measurement implements Jsonable, JsonSerializable
{
    public function __construct(protected Unit $measurement)
    {
    }

    public function getValue()
    {
        return $this->measurement->getValue();
    }

    public function getSymbol()
    {
        return $this->measurement->getSymbol();
    }

    public function jsonSerialize()
    {
        return $this->toJson();
    }

    public function toJson($options = 0)
    {
        return [
            'value' => $this->getValue(),
            'unit' => $this->getSymbol(),
        ];
    }

    public static function fromValue(int $value, string $unit)
    {
        return new self(Unit::from($value . ' ' . $unit));
    }
}
