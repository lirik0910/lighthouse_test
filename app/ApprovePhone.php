<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ApprovePhone extends Model
{
    protected $table = 'approve_phones';

    protected $fillable = [
      'phone', 'code', 'token', 'refresh_token_at'
    ];

    /*
     * Вычисляет количество минут, которое прошло с момента отправки кода и формирования токена
     */
    public function timeFromSend()
    {
        return date_diff(Carbon::now(), Carbon::parse($this->updated_at))->i;
    }
}
