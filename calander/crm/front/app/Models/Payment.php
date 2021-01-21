<?php
namespace App\Models;

use Config, CommonHelper;
use Carbon\Carbon;

class Payment extends Base {
    //use EventsWinner;
    public $num;
    protected $table = 'payment';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];
    
     
}
