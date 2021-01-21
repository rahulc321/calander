<?php
namespace App\Models;

use Config, CommonHelper;
use Carbon\Carbon;

class User extends Base {
    //use EventsWinner;
    public $num;
    protected $table = 'users';
    public $primaryKey = "id";

    protected $dates = ['created_at', 'updated_at'];
    
     
}
