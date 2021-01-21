<?php
namespace App\Models;

use Config, CommonHelper;
use Carbon\Carbon;

class Products extends Base {
    //use EventsWinner;
    public $num;
    protected $table = 'products';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];
    
     
}
