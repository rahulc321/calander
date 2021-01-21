<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session,
    Config,
    Request,
    Lang,
    DB;
use App\Helpers\ViewsHelper;
use App\Helpers\CommonHelper;
use App\Models\Cities;


class Base extends Model {

    public function scopeSort($query) {
        $sort = Request::get("sort");
        $order = Request::get("order");
        if (strlen($sort) == 0) {
            $sort = 'created_at';
            $order = 'desc';
        }
        return $query = $query->orderBy($sort, $order);
    }

    public function scopeSorttable($query) {
        $input = Request::all();
        $field = $input['columns'][$input['order'][0]['column']]['data'];
        $sort = $input['order'][0]['dir'];
        return $query = $query->orderBy($field, $sort);
    }

    function scopeSearch($query) {
        $search_data = json_decode(Request::get("search_data"));
        if ($search_data != null && count($search_data) > 0) {
            foreach ($search_data as $key => $search) {
                $query = $query->where($key, "like", "%" . $search . "%");
            }
        }
        return $query;
    }

    function scopeCitySearch($query) {
        $input = Request::all();
        $search = (isset($input['search']['value'])) ? $input['search']['value'] : "";
        $cities = Cities::where("city_name", "LIKE", "%" . $search . "%")->get();
        $query = $query->orWhereIn('city', $cities);
        return $query;
    }

    function scopeCreatedDesc($query) {
        return $query->orderBy("created_at", "DESC");
    }

    function scopeDpaginate($query) {
        $input = Request::all();
        $skip = (isset($input['start'])) ? $input['start'] : 0;
        $limit = (isset($input['length'])) ? $input['length'] : 10;
        $query->skip($skip)->take($limit);
    }

    function scopeByLang($query) {
        $lang_id = CommonHelper::getLang();
        $query->where("lang_id", $lang_id);
    }

    function scopeThisMonth($query) {
        return $query->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'));
    }

    public function getError($errors) {
        $errors = $errors->toArray();
        $ret_err = "";
        $err = array_values($errors);
        foreach ($errors as $key => $err) {
            $ret_err .= $err[0] . ", ";
        }
        return $ret_err;
    }

    /**
     *
     * get single data with where clause
     *
     */    
    public function getSingleBy($where = []) {
        return $this->where($where)->first();
    }

    /**
     *
     * get data with where clause
     *
     */    
    public function getBy($where = []) {
        return $this->where($where)->get();
    }

}
