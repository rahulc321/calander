<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 10/20/16
 * Time: 12:37 PM
 */

namespace App\Modules;


use Optimait\Laravel\Traits\CreatedUpdatedTrait;
use Optimait\Laravel\Traits\CreaterUpdaterTrait;

class Logs extends \Eloquent
{
    use CreatedUpdatedTrait, CreaterUpdaterTrait;
    protected $table = 'activity_logs';

    protected $fillable = ['log_text', 'disposition', 'status_id'];

    public function loggable()
    {
        return $this->morphTo();
    }

}