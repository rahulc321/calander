<?php
namespace App\Models;

use Config, CommonHelper;
use Carbon\Carbon;

class Review extends Base {
    //use EventsWinner;
    public $num;
    protected $table = 'review';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];
    
     
}
