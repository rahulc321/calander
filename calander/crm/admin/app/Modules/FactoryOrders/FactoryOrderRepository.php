<?php

namespace App\Modules\FactoryOrders;

use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Repos\EloquentRepository;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class FactoryOrderRepository extends EloquentRepository
{
    public $validator;

    protected $insertedId;
    protected $optionsView;

    public function __construct(FactoryOrder $factoryOrder, FactoryOrderValidator $factoryOrderValidator)
    {
        $this->model = $factoryOrder;
        $this->validator = $factoryOrderValidator;
    }

    public function getPaginated($items = 10, $factoryOrderBy = 'created_at', $factoryOrderType = 'DESC')
    {
        return $this->model->forMe()->with('items')->orderBy($factoryOrderBy, $factoryOrderType)->paginate($items);
    }

    /**
     * Description
     */
    public function getSearchedPaginated($searchData, $items = 10, $factoryOrderBy = 'inventory_id', $factoryOrderType = 'ASC')
    {
        return $this->model->forMe()
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

                if (@$searchData['product_id'] != '') {
                    $query->whereHas('items', function ($q) use ($searchData) {
                        $q->where('product_id', '=', $searchData['product_id']);
                    });
                }


            })
            ->orderBy($factoryOrderBy, $factoryOrderType)->paginate($items);
    }


    /**
     * get the factoryOrders for the provided ids
     *
     * @param array $ids
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getIn(array $ids)
    {

        return $this->model->whereIn('id', $ids)->get();
    }

    /*
     * @param $factoryOrderData
     * @return bool
     */
    public function placeOrder($data)
    {
        $factoryOrderModel = parent::getNew($data);

        if ($factoryOrderModel->save()) {
            $this->insertedId = $factoryOrderModel->id;
            $totalPrice = 0;
            foreach ($data['variants'] as $productId => $variants) {
                foreach ($variants as $k => $variantId) {
                    $buyingPrice = $data['buying_price'][$productId];
                    $qty = $data['qty'][$productId][$k];
                    if ($qty == '') {
                        continue;
                    }

                    $factoryOrderModel->items()->save(new Item([
                        'product_id' => $productId,
                        'variant_id' => $variantId,
                        'qty' => $qty,
                        'price' => $buyingPrice
                    ]));
                    $totalPrice += ($qty * $buyingPrice);
                }


            }
            $factoryOrderModel->price = $totalPrice;
            $factoryOrderModel->save();

            event('factoryOrder.saved', array($factoryOrderModel, $data, false));
            return $factoryOrderModel;
        }
        throw new ApplicationException('FactoryOrder cannot be added at this moment. Please try again later.');
    }

    public function shipCart($id, $cartData)
    {
        \DB::beginTransaction();
        try {
            $factoryOrderModel = $this->getById($id);
            $total = 0;
            foreach ($cartData['shipped_qty'] as $id => $qty) {
                $item = Item::find($id);
                $addedQty = $qty - $item->shipped_qty;
                Item::where('id', '=', $id)->update([
                    'shipped_qty' => $qty,
                ]);
                $variant = $item->variant;
                if ($variant) {
                    $newQty = $variant->qty + $addedQty;
                    $variant->qty = $newQty;
                    $variant->save();
                }

                $total += $item->price * $qty;
            }
            $factoryOrderModel->price = $total;
            if (@$cartData['close']) {
                $factoryOrderModel->status = FactoryOrder::STATUS_RECEIVED;
            }
            $factoryOrderModel->save();
            event('factoryOrder.received', array($factoryOrderModel));
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new \Exception('Somethinw went wrong.');
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
    public function checkDuplicateFactoryOrders($name, $id = 0)
    {
        //echo $email;
        if ($this->model->where('name', $name)->where('id', '!=', $id)->count()) {
            throw new ApplicationException('FactoryOrder already exists');
        }
        //print_r(\DB::getQueryLog());
    }

    public function deleteFactoryOrder($id)
    {
        $factoryOrder = $this->getById($id);
        if (is_null($factoryOrder)) {
            throw new ResourceNotFoundException('FactoryOrder Not Found');
        }

        /*$name = $factoryOrder->filename;
        @unlink('./uploads/factoryOrders/'.$name);*/
        if ($factoryOrder->selfDestruct()) {
            // print_r(DB::getQueryLog());
            return true;
        }

        return false;
    }

    public function deleteCartItem($id)
    {
        $factoryOrderItem = Item::find($id);
        if (is_null($factoryOrderItem)) {
            throw new ResourceNotFoundException('Item Not Found');
        }
        /*$name = $factoryOrder->filename;
        @unlink('./uploads/factoryOrders/'.$name);*/
        if ($factoryOrderItem->selfDestruct()) {
            // print_r(DB::getQueryLog());
            return true;
        }

        return false;
    }

}