<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baby extends Model
{
    use HasFactory;

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    public function parents()
    {
        return $this->belongsToMany(User::class);
    }

    public function parentInvites()
    {
        return $this->hasMany(ParentInvite::class);
    }

    protected static function booted()
    {
        // Only allow listing logged in user's own babies
        static::addGlobalScope('parent', function (Builder $builder) {
            $builder->whereHas('parents', function (Builder $query) {
                $query->where('user_id', auth()->user()->id);
            });
        });
    }
}
