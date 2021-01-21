<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Order;
use App\Modules\Products\Variant;
use App\Modules\Users\UserRepository;
use App\User;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;

class StatsController extends Controller
{

    public function getSales()
    {

        $query = Variant::select([\DB::raw("v.*, sum(oi.qty) as total, p.price, p.buying_price, p.name as productName,
         (sum(oi.qty) * p.price) as sellingPrice, ((sum(oi.qty) * p.price) - (sum(oi.qty) * p.buying_price)) as profit ")])
            ->from(rawQ('variations v'))
            ->leftJoin(rawQ('products p'), 'v.product_id', '=', 'p.id')
            ->leftJoin(rawQ('order_items oi'), function ($join) {
                $join->on('oi.variant_id', '=', 'v.id');
                /*$join->on('payments.deleted_at', 'IS', DB::raw('NOT NULL'));*/
            })
            ->leftJoin(rawQ('orders o'), function ($join) {
                $join->on('oi.order_id', '=', 'o.id');
                /*$join->on('payments.deleted_at', 'IS', DB::raw('NOT NULL'));*/
            })
            ->whereIn('o.status', [Order::STATUS_SHIPPED, Order::STATUS_PAID])
            ->groupBy('oi.variant_id');
        $data = Input::all();
        if (Input::get('search')) {

            $query->where(function ($q) use ($data) {
                if (@$data['date_from'] != '') {
                    $q->whereRaw("DATE(o.created_at) >= '" . \DateTime::createFromFormat('d/m/Y', urldecode($data['date_from']))->format("Y-m-d") . "'");
                }

                if (@$data['date_to'] != '') {
                    $q->whereRaw("DATE(o.created_at) <= '" . \DateTime::createFromFormat('d/m/Y', urldecode($data['date_to']))->format("Y-m-d") . "'");
                }
            });
        }
        $variants = $query
            ->orderBy(Input::get('orderBy', 'total'), 'DESC')
            ->get();

        if(@$data['type'] == 'variant'){
             return sysView('stats.variant', compact('variants'));
        }
        return sysView('stats.sales', compact('variants'));
    }

    public function getClients()
    {
        $data['topClients'] = User::select([\DB::raw("u.*, sum(o.price) as total")])
            ->from(rawQ('users u'))
            ->leftJoin(rawQ('orders o'), function ($join) {
                $join->on('o.created_by', '=', 'u.id');
            })
            ->where('o.status', '=', Order::STATUS_PAID)
            ->customers()
            ->groupBy('o.created_by')
            ->orderBy('total', 'DESC')
            ->limit(10)
            ->get();

        $data['topClientsThisMonth'] = User::select([\DB::raw("u.*, sum(o.price) as total")])
            ->from(rawQ('users u'))
            ->leftJoin(rawQ('orders o'), function ($join) {
                $join->on('o.created_by', '=', 'u.id');
            })
            ->where('o.status', '=', Order::STATUS_PAID)
            ->whereRaw("MONTH(o.created_at) = MONTH(CURDATE()) AND YEAR(o.created_at) = YEAR(CURDATE())")
            ->groupBy('o.created_by')
            ->customers()
            ->orderBy('total', 'DESC')
            ->limit(10)
            ->get();

        $data['topClientsOwnsMoney'] = User::select([\DB::raw("u.*, sum(o.price) as total")])
            ->from(rawQ('users u'))
            ->leftJoin(rawQ('orders o'), function ($join) {
                $join->on('o.created_by', '=', 'u.id');
                /*$join->on('payments.deleted_at', 'IS', DB::raw('NOT NULL'));*/
            })
            ->where('o.status', '=', Order::STATUS_SHIPPED)
            ->whereRaw("MONTH(o.created_at) = MONTH(CURDATE()) AND YEAR(o.created_at) = YEAR(CURDATE())")
            ->groupBy('o.created_by')
            ->orderBy('total', 'DESC')
            ->limit(10)
            ->get();


        $data['topSalesMan'] = User::select([\DB::raw("mu.*,
        (select sum(o.price) as total from users u left join orders o on o.created_by = u.id
        where o.status = '6' and user_type_id = '2' and u.created_by = mu.id group by u.created_by) as totalIncome")])
            ->from(rawQ('users mu'))
            ->sales()
            ->having('totalIncome', '>', 0)
            ->orderBy(rawQ("totalIncome * (commission/100)"), 'DESC')
            ->get();

        $data['topSalesManThisMonth'] = User::select([\DB::raw("mu.*,
        (select sum(o.price) as total from users u left join orders o on o.created_by = u.id
        where o.status = '6' and user_type_id = '2'
         and MONTH(o.created_at) = MONTH(CURDATE()) AND YEAR(o.created_at) = YEAR(CURDATE())
         and u.created_by = mu.id group by u.created_by) as totalIncome")])
            ->from(rawQ('users mu'))
            ->sales()
            ->having('totalIncome', '>', 0)
            ->orderBy(rawQ("totalIncome * (commission/100)"), 'DESC')
            ->get();

        return sysView('stats.clients', compact('data'));
    }


    public function getBudgetSales(){
        $countries = User::sales()->select('country')->groupBy('country')->get()->pluck('country')->toArray();
        abort_if(count($countries) == 0, 404);
        $salesPersons = User::sales()->where(function($q) use($countries) {
            $data = Input::all();

            if(@$data['country'] != ''){
                $q->where('country', '=', @$data['country']);
            }
            else{
                $q->where('country', '=', $countries[0]);
            }
        })->get();

        $allSalesPerson = User::sales()->get();
        return sysView('stats.budget-sales', compact('countries', 'salesPersons', 'allSalesPerson'));
    }

}
