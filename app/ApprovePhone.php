<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovePhone extends Model
{
    protected $table = 'approve_phones';

    protected $fillable = [
      'phone_number', 'code', 'token', 'refresh_token_at', 'country_code_id'
    ];

    public function country_code(): BelongsTo
    {
        return $this->belongsTo(CountryCode::class);
    }

    /*
     * Вычисляет количество минут, которое прошло с момента отправки кода и формирования токена
     */
    public function timeFromSend()
    {
        return date_diff(Carbon::now(), Carbon::parse($this->updated_at))->i;
    }
}
