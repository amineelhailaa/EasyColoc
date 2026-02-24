<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Colocation extends Model
{
    //
    protected $fillable = [
        'name','description','avatar'
    ];


    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class,'colocation_id');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class,'colocation_id');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class,'colocation_id');
    }

    public function splits(): HasMany
    {
        return $this->hasMany(Split::class,'colocation_id');
    }
}
