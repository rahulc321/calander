<?php

namespace App\Modules\Products;


use App\Modules\Orders\Order;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Repos\EloquentRepository;
use Optimait\Laravel\Traits\CallbackForRequestTrait;
use Optimait\Laravel\Traits\UploaderTrait;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ProductRepository extends EloquentRepository
{
    use CallbackForRequestTrait, UploaderTrait;
    public $validator;

    public function __construct(Product $product, ProductValidator $productValidator)
    {
        $this->model = $product;
        $this->validator = $productValidator;
    }

    public function getSearchedPaginated($searchData, $items = 10, $orderBy = 'title', $orderType = 'ASC', $where = null)
    {
        $model = $this->model->where('id', '!=', 0)->with('collection', 'photos', 'currentOrders');

        if (!is_null($where) && is_callable($where)) {
            $model->where($where);
        }
        $model->where(function ($q) use ($searchData) {
            if (@$searchData['keyword']) {
                $q->where(function ($q) use ($searchData) {
                    $q
                        ->orWhere('name', 'LIKE', '%' . urldecode($searchData['keyword']) . '%');
                });
            }
            if (@$searchData['collection_id']) {
                $q->where('collection_id', '=', $searchData['collection_id']);
            }
        });
        return $model->orderBy($orderBy, $orderType)->paginate($items);
    }

    public function getPaginated($items = 10, $orderBy = 'title', $orderType = 'ASC', $where = null)
    {
        $model = $this->model->where('id', '!=', 0)->with('collection', 'photos', 'currentOrders');

        if (!is_null($where) && is_callable($where)) {
            $model->where($where);
        }
        return $model->orderBy($orderBy, $orderType)->paginate($items);
    }


    public function createProduct($productData = array(), \Closure $c = null)
    {
        $productData = array_merge($productData, $this->processCallbackForRequest($c));

        $product = parent::getNew($productData);
        if ($product->save()) {
            event('product.saved', array($product, $productData, false));
            return $product;
        }
        throw new ApplicationException("Cannot Add Product Template.");
    }


    public function updateProduct($id, $productData = array(), \Closure $c = null)
    {
        $productData = array_merge($productData, $this->processCallbackForRequest($c));
        $product = $this->getById($id);
        $product->fill($productData);
        if ($product->save()) {
            event('product.saved', array($product, $productData));
            return $product;
        }

        throw new ApplicationException("Cannot Add Product.");
    }


    public function deleteProduct($id)
    {
        $product = $this->getById($id);
        if (is_null($product)) {
            throw new ResourceNotFoundException('Product Not Found');
        }

        /*$name = $product->filename;
        @unlink('./uploads/inventories/'.$name);*/
        if ($product->selfDestruct()) {
            // print_r(DB::getQueryLog());
            return true;
        }

        return false;
    }

    public function getTotalOrdered($searchData, $items = 10)
    {
        return $this->model
            ->where(function ($q) use ($searchData) {
                if (@$searchData['keyword'] != '') {
                    $q->where('name', 'LIKE', '%' . $searchData['keyword'] . '%');
                }
            })
            ->whereHas('totalOrders', function ($q) use ($searchData) {
                $q->whereHas('order', function ($q) {
                    $q->whereIn('status', [Order::STATUS_ORDERED, Order::STATUS_SHIPPED, Order::STATUS_PAID]);
                });
                if (@$searchData['date_from'] != '') {
                    $q->whereRaw("DATE(created_at) >= '" . $searchData['date_from'] . "'");
                }

                if (@$searchData['date_to'] != '') {
                    $q->whereRaw("DATE(created_at) <= '" . $searchData['date_to'] . "'");
                }


            })->with(['totalOrders' => function ($q) use ($searchData) {
                $q->whereHas('order', function ($q) {
                    $q->whereIn('status', [Order::STATUS_ORDERED, Order::STATUS_SHIPPED, Order::STATUS_PAID]);
                });
                if (@$searchData['date_from'] != '') {
                    $q->whereRaw("DATE(created_at) >= '" . $searchData['date_from'] . "'");
                }

                if (@$searchData['date_to'] != '') {
                    $q->whereRaw("DATE(created_at) <= '" . $searchData['date_to'] . "'");
                }
            }], 'variants')->paginate($items);
    }

    public function deleteVariant($id)
    {
        $product = Variant::find($id);
        if (is_null($product)) {
            throw new ResourceNotFoundException('Product Not Found');
        }


        if ($product->selfDestruct()) {
            // print_r(DB::getQueryLog());
            return true;
        }

        return false;
    }
}