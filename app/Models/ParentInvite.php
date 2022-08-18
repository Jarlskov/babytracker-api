<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ParentInvite extends Model
{
    use HasFactory;

    public function baby(): BelongsTo
    {
        return $this->belongsTo(Baby::class);
    }
}
