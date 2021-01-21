<?php
namespace App\Models;

use Config, CommonHelper;
use Carbon\Carbon;

class CouponDetail extends Base {
    //use EventsWinner;
    public $num;
    protected $table = 'coupon_detail';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];
    
     
}
