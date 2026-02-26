<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'title',
        'amount',
        'date',
        'category_id',
        'membership_id',
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class,'category_id')->withTrashed();
    }


    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class,'membership_id');
    }

    public function colocation(): BelongsTo{
        return $this->belongsTo(Colocation::class,'colocation_id');
    }
}
