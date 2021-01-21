<?php
/**
 * Created by PhpStorm.
 * User: monkeyDluffy
 * Date: 2/12/2016
 * Time: 10:24 PM
 */

namespace App\Modules\Users\Traits;


use App\User;

trait UserHelper
{


    public function getPermissionsAttribute($value)
    {
        return json_decode($value);
    }

    public function setPermissionsAttribute($value)
    {
        $this->attributes['permissions'] = json_encode($value);
    }


    public function getProfilePicUrl($size = array(100, 100))
    {
        if ($this->photo_id != 0 && $this->photo_id != '') {
            return asset(@$this->photo->media->folder . $size[0] . 'X' . $size[1] . @$this->photo->media->filename);
        } else {
            return asset('assets/backend/img/avatar.png');
        }
    }


    public function getProfilePic($class = 'img-thumbnail', $size = array(100, 100))
    {
        return '<img src="' . $this->getProfilePicUrl($size) . '" class="' . $class . '">';
    }


    public function setUserType($typeId)
    {
        $this->user_type_id = $typeId;
    }


    public function city(){
        return $this->city;
    }
    public function fullName()
    {
        return $this->full_name;
    }

    public function shouldPayTax()
    {
        return in_array(strtolower($this->country), array_keys(config('currency.taxable')));
    }

    public function getTaxPercent()
    {
        if (!$this->shouldPayTax()) {
            return 0;
        }

        $taxes = config('currency.taxable');
        if (isset($taxes[strtolower($this->country)])) {
            return $taxes[strtolower($this->country)];
        }

        return 0;
    }

    public function hasOrderedInMonths($month = 3){
        return $this->orders()->whereRaw(\DB::raw("created_at >= now()-interval 3 month"))->count('id') > 0;
    }


    public static function getNewDebitorValue(){
        $user = User::select('debitor_number')->customers()->orderBy('debitor_number', 'DESC')->first();
        if($user->debitor_number > 0){
            return $user->debitor_number + 1;
        }
        return 1;
    }
}