<?php
namespace App\Modules\Users;


use Optimait\Laravel\Traits\CreatedUpdatedTrait;
use Optimait\Laravel\Traits\CreaterUpdaterTrait;

class Message extends \Eloquent
{
    use CreaterUpdaterTrait, CreatedUpdatedTrait;
    protected $table = 'user_messages';
    protected $fillable = ['user_id', 'message'];

}