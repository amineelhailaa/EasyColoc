<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\ImageUploadService;

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

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class,'colocation_id');
    }

    public function avatarUrl(?string $name = null, string $background = '0369a1'): string
    {
        $url = ImageUploadService::url($this->avatar);

        if ($url) {
            return $url;
        }

        $displayName = trim((string) ($name ?? $this->name ?? 'Colocation'));

        if ($displayName === '') {
            $displayName = 'Colocation';
        }

        return 'https://ui-avatars.com/api/?name='
            .urlencode($displayName)
            .'&background='
            .$background
            .'&color=ffffff';
    }
}
