<?php
namespace App\Models;

use Config, CommonHelper;
use Carbon\Carbon;

class Coupon extends Base {
    //use EventsWinner;
    public $num;
    protected $table = 'coupon';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];
    
     
}
