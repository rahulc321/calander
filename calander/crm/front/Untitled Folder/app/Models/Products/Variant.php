<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 12/29/16
 * Time: 4:46 PM
 */

namespace App\Modules\Products;


use App\Modules\FactoryOrders\FactoryOrder;
use App\Modules\Orders\Order;

class Variant extends \Eloquent
{
    protected $table = 'variations';
    protected $fillable = ['product_id', 'color_id', 'stock'];

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getTotalFactoryOrdered()
    {

        $query = \DB::table(\DB::raw("factory_order_items fi"))
            ->select([\DB::raw("sum(fi.qty) as total")])
            ->leftJoin(\DB::raw('factory_orders fo'), function ($join) {
                $join->on('fi.order_id', '=', 'fo.id');
                /*$join->on('payments.deleted_at', 'IS', DB::raw('NOT NULL'));*/
            })
            ->where("fo.status", '=', FactoryOrder::STATUS_ORDERED)
            ->where("fi.variant_id", "=", $this->id)
            ->groupBy('fi.variant_id')->first();

        return @$query->total ? $query->total : 0;
    }

    public function getTotalOrdered()
    {

        $query = \DB::table(\DB::raw("order_items fi"))
            ->select([\DB::raw("sum(fi.qty) as total")])
            ->leftJoin(\DB::raw('orders fo'), function ($join) {
                $join->on('fi.order_id', '=', 'fo.id');
                /*$join->on('payments.deleted_at', 'IS', DB::raw('NOT NULL'));*/
            })
            ->where("fo.status", '=', Order::STATUS_ORDERED)
            ->where("fi.variant_id", "=", $this->id)
            ->groupBy('fi.variant_id')->first();

        return @$query->total ? $query->total : 0;
    }

    public function selfDestruct()
    {
        return $this->delete();
    }

    public function getTotalrequitred()
    {

        $query = \DB::table(\DB::raw("order_items fi"))
            ->select([\DB::raw("sum(fi.total_required) as total")])
            ->leftJoin(\DB::raw('orders fo'), function ($join) {
                $join->on('fi.order_id', '=', 'fo.id');
                /*$join->on('payments.deleted_at', 'IS', DB::raw('NOT NULL'));*/
            })
            ->where("fo.status", '=', Order::STATUS_ORDERED)
            ->where("fi.variant_id", "=", $this->id)
            ->groupBy('fi.variant_id')->first();

        return @$query->total ? $query->total : 0;
    }

}