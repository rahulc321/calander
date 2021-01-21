<?php

namespace App\Modules\Orders;

use App\Modules\Inventory\Offers\Offer;
use App\Modules\Inventory\Orders;
use App\Modules\Inventory\Stocks\InventoryStockRepository;
use App\Modules\Products\Variant;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Repos\EloquentRepository;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use App\Modules\Orders\Item;
class OrderRepository extends EloquentRepository
{
    public $validator;

    protected $insertedId;
    protected $optionsView;

    public function __construct(Order $order, OrderValidator $orderValidator)
    {
        $this->model = $order;
        $this->validator = $orderValidator;
    }

    public function getPaginated($items = 10, $orderBy = 'created_at', $orderType = 'DESC')
    {
        $model = $this->model->forMe()->ordered()->with('items')->orderBy($orderBy, $orderType);
        return is_null($items) ? $model->get() : $model->paginate($items);
    }

    /**
     * Description
     */
    public function getSearchedPaginated($searchData, $items = 10, $orderBy = 'inventory_id', $orderType = 'ASC')
    {
        $model = $this->model->forMe()->ordered()
            ->with('items', 'creator.parent')
            ->where(function ($query) use ($searchData) {
                if (@$searchData['oid'] != '') {
                    $query->where('OID', 'LIKE', $searchData['oid']);
                }

                if (@$searchData['date_from'] != '') {
                    $query->whereRaw("DATE(created_at) >= '" . \DateTime::createFromFormat('d/m/Y', urldecode($searchData['date_from']))->format("Y-m-d") . "'");
                }

                if (@$searchData['date_to'] != '') {
                    $query->whereRaw("DATE(created_at) <= '" . \DateTime::createFromFormat('d/m/Y', urldecode($searchData['date_to']))->format("Y-m-d") . "'");
                }

                if (@$searchData['status'] != '') {
                    $query->where('status', '=', $searchData['status']);
                }

                if (@$searchData['user_id'] != '') {
                    $query->where('created_by', '=', $searchData['user_id']);
                }
            })
            ->orderBy($orderBy, $orderType);


        return is_null($items) ? $model->get() : $model->paginate($items);
    }


    public function getRefundsPaginated($items = 10, $orderBy = 'created_at', $orderType = 'DESC')
    {
        return $this->model->forMe()->exceptShopping()->hasRefunds()->with('refundItems')->orderBy($orderBy, $orderType)->paginate($items);
    }

    /**
     * get the orders for the provided ids
     *
     * @param array $ids
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getIn(array $ids)
    {

        return $this->model->whereIn('id', $ids)->get();
    }

    /**
     * @param $orderData
     * @return bool
     */
    public function addToCart($id, $qty)
    {
        Order::Current()->addToCart(Variant::find($id), $qty);
        return true;

    }

    public function addOfferToCart($orderData)
    {
        $offer = Offer::find($orderData['id']);
        if (!$offer) {
            throw new ApplicationException("Invalid Offer");
        }
        Order::Current()->addOfferToCart($offer->stock->variant_id, $offer, $orderData['qty']);
        return true;
    }

    public function updateCart($cartData)
    {
        foreach ($cartData['ids'] as $k => $id) {
            if (@$cartData['qty'][$id] == '' || $cartData['qty'][$id] == 0) {
                continue;
            }

            if (isset($cartData['max_qty'][$id]) && $cartData['max_qty'][$id] < $cartData['qty'][$id]) {
                throw new ApplicationException("Cannot update offer items to the requested quantity");
            }

            Item::where('id', '=', $id)->update([
                'qty' => $cartData['qty'][$id]
            ]);

        }
        return true;

    }

    public function shipCart($id, $cartData)
    {
        \DB::beginTransaction();
        try {
            $orderModel = $this->getById($id);
            $total = 0;
            foreach ($cartData['shipped_qty'] as $id => $qty) {
                /*$item = Item::find($id);*/
                $column = @$cartData['shipOrder'] ? 'shipped_qty' : 'qty';
                Item::where('id', '=', $id)->update([
                    $column => $qty,
                    'discount' => $cartData['discount'][$id],
                    'note' => $cartData['note'][$id]
                ]);
                /*$total += $item->getDiscountedPrice() * $item->shipped_qty;*/
            }
            if(@$cartData['shipOrder']){
                /*$orderModel->currency = $cartData['currency'];
                $orderModel->exchange = $cartData['exchange'];*/
                $orderModel->ship($cartData['shipping_price'], $cartData['due_date']);
            }

            if(@$cartData['expected_shipping_date'] != ''){
                $orderModel->expected_shipping_date = \DateTime::createFromFormat('d/m/Y', $cartData['expected_shipping_date'])->format("Y-m-d");
                $orderModel->save();
            }

            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            //throw new \Exception($e);
            throw new \Exception("Something went wrong");
        }

    }

    public function refundCart($id, $cartData)
    {
        \DB::beginTransaction();
        try {
            $orderModel = $this->getById($id);
            $total = 0;
            foreach ($cartData['refund_qty'] as $id => $qty) {
                /*$item = Item::find($id);*/
                Item::where('id', '=', $id)->update([
                    'refund_qty' => $qty,
                ]);
                /*$total += $item->getDiscountedPrice() * $item->shipped_qty;*/
            }
            $orderModel->is_refund = 1;
            $orderModel->refund_type = @$cartData['refund_type'];
            $orderModel->refund_status = Order::REFUND_STATUS_PENDING;
            $orderModel->refund_date = date("Y-m-d");
            $orderModel->save();

            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new \Exception("Something went wrong");
        }

    }

    /*
     * @param $orderData
     * @return bool
     */
    public function updateOrder($id, $orderData, InventoryStockRepository $stockRepository)
    {
        $this->startTransaction();
        $orderModel = $this->getById($id);
        $orderModel->fill($orderData);
        if (@$orderData['amount_paid'] != '') {
            $orderModel->paid += $orderData['amount_paid'];
            $orderModel->payments()->save(new Payment(array(
                'paid' => $orderData['amount_paid']
            )));
        }

        try {
            if ($orderModel->save()) {
                $orderModel->releaseQuantity();
                $orderModel->transactions()->delete();
                foreach ($orderData['stock'] as $k => $v) {
                    $stock = $stockRepository->getById($v);
                    $transaction = $stock->newTransaction();
                    $transaction->hold($orderData['quantity'][$k], 'Placed an order', $orderData['price'][$k]);
                    $transaction->order_id = $orderModel->id;
                    $transaction->cost = $orderData['price'][$k];
                    $transaction->save();
                    /*echo $transaction->id;*/
                }
                $this->commitTransaction();
            }
            return true;
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw new ApplicationException($e->getMessage());
        }

        /*$orderModel->update($orderData);*/

        return false;
    }

    public function updateBilling($id, $billingData)
    {
        $this->startTransaction();
        $orderModel = $this->getById($id);
        try {
            $orderModel->billing()->delete();
            $orderModel->billing()->save(new Billing($billingData));
            $this->commitTransaction();
            return true;
        } catch (\Exception $e) {
            $this->rollbackTransaction();
            throw new ApplicationException($e->getMessage());
        }
    }

    public function getInsertedId()
    {
        return $this->insertedId;
    }

    /*
     * @param $name the name used to check the duplicate record in the db
     * @return int
     */
    public function checkDuplicateOrders($name, $id = 0)
    {
        //echo $email;
        if ($this->model->where('name', $name)->where('id', '!=', $id)->count()) {
            throw new ApplicationException('Order already exists');
        }
        //print_r(\DB::getQueryLog());
    }

    public function deleteOrder($id)
    {
        $order = $this->getById($id);
        if (is_null($order)) {
            throw new ResourceNotFoundException('Order Not Found');
        }

        /*$name = $order->filename;
        @unlink('./uploads/orders/'.$name);*/
        if ($order->selfDestruct()) {
            // print_r(DB::getQueryLog());
            return true;
        }
        return false;
    }

    public function deleteCartItem($id)
    {
        $oId= decrypt($id);
        $orderItem = Item::find($oId);
        if (is_null($orderItem)) {
            throw new ResourceNotFoundException('Item Not Found');
        }
        /*$name = $order->filename;
        @unlink('./uploads/orders/'.$name);*/
        if ($orderItem->selfDestruct()) {
            // print_r(DB::getQueryLog());
            return true;
        }

        return false;
    }
}