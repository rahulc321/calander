<?php
namespace App\Models;

use Config, CommonHelper;
use Carbon\Carbon;

class Detail extends Base {
    //use EventsWinner;
    public $num;
    protected $table = 'tbl_details';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];
    
     
}
