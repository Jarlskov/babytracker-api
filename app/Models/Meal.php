<?php

namespace App\Models;

use App\Casts\MeasurementCast;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property MeasurementCast $amount
 */
class Meal extends Model
{
    use HasFactory;

    protected $appends = [
        'amount',
    ];

    protected $casts = [
        'amount' => MeasurementCast::class,
        'start' => 'datetime',
    ];

    protected $fillable = [
        'amount',
        'start',
        'note',
    ];

    protected $hidden = [
        'meal_amount',
        'meal_unit',
    ];

    protected $with = [
        'mealType',
    ];

    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }

    public function mealType()
    {
        return $this->belongsTo(MealType::class);
    }

    public function getStartAttribute($value)
    {
        return (new Carbon($value))->timezone('Europe/Copenhagen');
    }

    public function setMealAmountAttribute($mealAmount)
    {
        throw new \Exception('Setting $meal_amount is not allowed. Use $amount.');
    }

    public function setMealUnitAttribute($mealUnit)
    {
        throw new \Exception('Setting $meal_unit is not allowed. Use $amount.');
    }

    public function toArray()
    {
        $this->amount;

        return parent::toArray();
    }
}
