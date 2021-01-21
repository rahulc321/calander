<?php
namespace App\Models;

use Config, CommonHelper;
use Carbon\Carbon;

class Cart extends Base {
    //use EventsWinner;
    public $num;
    protected $table = 'cart';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];
    
     
}
