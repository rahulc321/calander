<?php
namespace App\Models;

use Config, CommonHelper;
use Carbon\Carbon;

class Newsletter extends Base {
    //use EventsWinner;
    public $num;
    protected $table = 'news_letter';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];
    
     
}
