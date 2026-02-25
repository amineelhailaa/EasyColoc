<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    //
    protected $fillable = ['name'];
    public function colocation(): belongsTo{
        return $this->belongsTo(Colocation::class, 'colocation_id');
    }


    public function expenses(): belongsTo {
        return $this->belongsTo(Expense::class,'category_id');
    }
}
