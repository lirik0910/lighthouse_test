<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CountryCode extends Model
{
    protected $fillable = [
        'country', 'code'
    ];

    public function phones(): HasMany
    {
        return $this->hasMany(ApprovePhone::class);
    }
}
