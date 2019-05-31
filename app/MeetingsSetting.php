<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetingsSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'minimal_cost', 'partner_age', 'safe_deal', 'photos_verified', 'fully_verified', 'charity'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
