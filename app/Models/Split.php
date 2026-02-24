<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Split extends Model
{

    protected $fillable = [
        'part', //money
        'debuteur_id', //who should pay
        'crediteur_id',
    ];
    //

    public function debuteur(): BelongsTo{
        return $this->belongsTo(Membership::class,'debuteur_id');
    }

    public function crediteur(): BelongsTo{
        return $this->belongsTo(Membership::class,'crediteur_id');
    }
}
