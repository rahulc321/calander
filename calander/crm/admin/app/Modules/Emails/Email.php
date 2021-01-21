<?php
namespace App\Modules\Emails;


class Email extends \Eloquent
{

    protected $table = 'emails';
    protected $fillable = ['subject', 'message', 'date_interval'];

    public static function GetByInterval($interval){
        return Email::where('date_interval', '=', $interval)->first();
    }
}