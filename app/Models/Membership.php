<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membership extends Model
{
    protected $fillable = [
        'user_id','colocation_id','status','role','balance','left_at'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function colocation(): BelongsTo{
        return $this->belongsTo(Colocation::class, 'colocation_id');
    }


    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function splitsAsDebuteur(): HasMany{
        return $this->hasMany(Split::class, 'debuteur_id');
    }




    public function splitsAsCrediteur(): HasMany{
        return $this->hasMany(Split::class, 'crediteur_id');
    }

}
