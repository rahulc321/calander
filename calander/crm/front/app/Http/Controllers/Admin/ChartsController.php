<?php
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Modules\Orders\Order;
use App\Modules\Users\UserRepository;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;

class ChartsController extends Controller
{
    public function getIndex()
    {
        return redirect(sysUrl('charts/observation'));
    }

    public function getPurchase()
    {
        return sysView('charts.purchase');
    }

    public function postPurchase(UserRepository $repo)
    {
        $repo->validator->setDefault('purchase-chart')->with(Input::all())->isValid();

        $searchData = Input::all();
        $dateAr = createDateRangeArray($searchData['date_from'], $searchData['date_to']);

        $chartData = [];
        $column = 'price';

        $users = $repo->getIn(Input::get('users'));
        foreach ($users as $user) {
            $data = [];
            $data['name'] = $user->fullName();
            $dateData = [];
            $dataByDates = $user->orders()->paid()->forChart($searchData)->groupBy('payment_date');
            foreach ($dateAr as $date) {
                /*$dateData[$date][] = isset($dataByDates[$date]) ? @$dataByDates[$date][0]->return_amount - @$dataByDates[$date][0]->credit : 0;*/
                $val = (float)isset($dataByDates[$date]) ? (float)(@$dataByDates[$date]->sum($column)) : (float)0.00;
                $dateData[] = (float)$val;
            }
            $data['data'] = $dateData;
            $chartData[] = $data;
        }

        return response()->json([
            'data' => $chartData,
            'label' => $dateAr,
            'subtitle' => 'Price',
            'unit' => 'Price',
        ]);

    }

    public function getSales()
    {
        return sysView('charts.sales');
    }


    public function postSales(UserRepository $repo)
    {
        $repo->validator->setDefault('sales-chart')->with(Input::all())->isValid();

        $searchData = Input::all();
        $dateAr = createDateRangeArray($searchData['date_from'], $searchData['date_to']);

        $chartData = [];
        $column = Input::get('column', 'sales');

        $data = [];
        $data['name'] = $column;
        $dateData = [];
        $dataByDates = Order::selectRaw('o.*, o.price as sales, sum(oi.shipped_qty * p.buying_price) as cost')
            ->from(rawQ('orders o'))
            ->leftJoin(rawQ('order_items oi'), 'oi.order_id', '=', 'o.id')
            ->leftJoin(rawQ('products p'), 'oi.product_id', '=', 'p.id')
            ->paid()->groupBy(rawQ('o.id'))->forChart($searchData)->groupBy('payment_date');
        foreach ($dateAr as $date) {
            /*$dateData[$date][] = isset($dataByDates[$date]) ? @$dataByDates[$date][0]->return_amount - @$dataByDates[$date][0]->credit : 0;*/
            if ($column == 'sales') {
                $val = (float)isset($dataByDates[$date]) ? (float)(@$dataByDates[$date]->sum($column)) : (float)0.00;
            } else {
                $val = (float)isset($dataByDates[$date]) ? (float)(@$dataByDates[$date]->sum('sales')) - (float)(@$dataByDates[$date]->sum('cost')) : (float)0.00;
            }

            $dateData[] = (float)$val;
        }
        $data['data'] = $dateData;
        $chartData[] = $data;

        return response()->json([
            'data' => $chartData,
            'label' => $dateAr,
            'subtitle' => $column,
            'unit' => 'EUR',
            'total' => (float) @array_sum($data['data'])
        ]);

    }


    public function postOldSales(UserRepository $repo)
    {
        $repo->validator->setDefault('purchase-chart')->with(Input::all())->isValid();

        $searchData = Input::all();
        $dateAr = createDateRangeArray($searchData['date_from'], $searchData['date_to']);

        $chartData = [];
        $column = 'price';

        $users = $repo->getIn(Input::get('users'));
        foreach ($users as $user) {
            $data = [];
            $data['name'] = $user->fullName();
            $dateData = [];
            $dataByDates = $user->orders()->paid()->forChart($searchData)->groupBy('payment_date');
            /*pd($dataByDates);*/
            foreach ($dateAr as $date) {
                /*$dateData[$date][] = isset($dataByDates[$date]) ? @$dataByDates[$date][0]->return_amount - @$dataByDates[$date][0]->credit : 0;*/
                $val = (float)isset($dataByDates[$date]) ? (float)(@$dataByDates[$date]->sum($column)) : (float)0.00;

                $dateData[] = (float)$val;
            }
            $data['data'] = $dateData;
            $chartData[] = $data;
        }

        return response()->json([
            'data' => $chartData,
            'label' => $dateAr,
            'subtitle' => 'Price',
            'unit' => 'Price',
            'total' => @array_sum($data['data'])
        ]);

    }

}
