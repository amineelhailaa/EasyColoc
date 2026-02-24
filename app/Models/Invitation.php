<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    //
    protected $fillable = ['email','status','token'];

    public function colocation(): BelongsTo {
        return $this->belongsTo(Colocation::class,'colocation_id');
    }
}
