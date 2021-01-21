<?php
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Modules\Orders\Order;
use App\Modules\Orders\OrderRepository;
use App\Modules\Users\UserRepository;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;

class RefundsController extends Controller
{
    private $orders;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orders = $orderRepository;
    }

    public function getIndex()
    {
        if (\Request::ajax()) {
            return $this->getList();
        }
        /*$refunds = $this->orders->getRefundsPaginated(10);*/
        return sysView('refunds/index');
    }

    public function getList($id = 0)
    {
        if (Input::get('search')) {
            $orders = $this->orders->getSearchedPaginated(\Input::all(), 10, Input::get('orderBy', 'created_at'), Input::get('orderType', 'DESC'));
        } else {
            $orders = $this->orders->getRefundsPaginated(10, Input::get('orderBy', 'refund_date'), Input::get('orderType', 'DESC'));
        }

        /*echo 'hello world';*/

        return response()->json(array(
            'data' => sysView('refunds.partials.list', compact('orders'))->render(),
            'pagination' => sysView('includes.pagination', ['data' => $orders])->render(),
        ));
    }


    public function putAction(){
        if(!Input::get('order_id')){
            throw new ApplicationException("Invalid Request");
        }

        $order = $this->orders->getById(Input::get('order_id'));
        $order->refund_status = Input::get('refund_status');
        $order->credit_note = Input::get('credit_note');
        $order->save();

        return redirect()->back()->with(['success' => 'Refund Action Applied']);
    }
}
