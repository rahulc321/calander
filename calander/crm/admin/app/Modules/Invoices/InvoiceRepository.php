<?php

namespace App\Modules\Invoices;

use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Repos\EloquentRepository;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use App\Modules\Orders\Order;
class InvoiceRepository extends EloquentRepository
{
    public $validator;

    protected $insertedId;
    protected $optionsView;

    public function __construct(Invoice $invoice, InvoiceValidator $invoiceValidator)
    {
        $this->model = $invoice;
        $this->validator = $invoiceValidator;
    }

    public function getPaginated($items = 10, $invoiceBy = 'created_at', $invoiceType = 'DESC', $unpaid=0)
    {
        //return $this->model->forMe()->with('order')->orderBy($invoiceBy, $invoiceType)->paginate($items);
        
        $model = $this->model->forMe()->with('order')->orderBy($invoiceBy, $invoiceType);
        if($unpaid==1){
               return $model->get();
           }
        return is_null($items) ? $model->get() : $model->paginate($items);
}
    public function getForCommission($items = 10, $searchData = [])
    {
       $model = $this->model->forMe()->paid()->with('order.salesPerson', 'order.items');
        $model->where(function ($q) use ($searchData) {
            if (@$searchData['sales_id'] != '') {
                $q->whereHas('order', function ($q) use ($searchData) {
                    $q->where('sales_person_id', '=', $searchData['sales_id']);
                });
            }
            // 5 July changes
            if (@$searchData['date_from'] != '') {
                   $q->whereRaw("DATE(created_at) >= '" . \DateTime::createFromFormat('d/m/Y', urldecode($searchData['date_from']))->format("Y-m-d") . "'");
                }

                if (@$searchData['date_to'] != '') {
                    $q->whereRaw("DATE(created_at) <= '" . \DateTime::createFromFormat('d/m/Y', urldecode($searchData['date_to']))->format("Y-m-d") . "'");
                }
                // 5 July changes

        })->orderBy('id', 'desc');
        return is_null($items) ? $model->get() : $model->paginate($items);
    }

    /**
     * Description
     */
    public function getSearchedPaginated($searchData = array(), $items = 10, $invoiceBy = 'inventory_id', $invoiceType = 'ASC',$unpaid=0)
    {
        // if($searchData['status']=='due'){

        //    $model = $this->model->join('orders','orders.id','=','invoices.order_id')
        //     ->where('orders.due_date','<',date("Y-m-d"))->get();
        //    // $model = $this->model->forMe()->with(['orderdue' => function ($query){
        //    //      $query->where("due_date", '<', date("Y-m-d"));
        //    //  }])
        //    // ->orderBy($invoiceBy, $invoiceType);
             
        //    // echo '<pre>';print_r(count($data1));die; 
        // }else{

        $model = $this->model->forMe()->with('order')
            ->where(function ($query) use ($searchData) {
                if (@$searchData['iid'] != '') {
                    $query->where('IID', 'LIKE', $searchData['iid']);
                }

               if (@$searchData['date_from'] != '') {
                    $query->whereRaw("DATE(created_at) >= '" . \DateTime::createFromFormat('d/m/Y', urldecode($searchData['date_from']))->format("Y-m-d") . "'");
                }

                if (@$searchData['date_to'] != '') {
                    $query->whereRaw("DATE(created_at) <= '" . \DateTime::createFromFormat('d/m/Y', urldecode($searchData['date_to']))->format("Y-m-d") . "'");
                }


                if (@$searchData['status'] != '') {
                    $date= date('Y-m-d');
                    if(@$searchData['status'] == 'due'){
                        $query->where('issue_date','<',$date)->where('status', '=', 2);
                    }else{
                    $query->where('status', '=', $searchData['status']);
                    }
                }

            
                if (@$searchData['user_id'] != '') {
                    $query->where('user_id', '=', $searchData['user_id']);
                }
            })
           ->orderBy($invoiceBy, $invoiceType);//->paginate($items);
           
      
      if($unpaid==1){
               return $model->get();
           }
           // echo '<pre>';
           // print_r($model->get());
          return is_null($items) ? $model->get() : $model->paginate($items);
    }

    public function getSearchedPaginated1($searchData = array(), $items = 10, $invoiceBy = 'inventory_id', $invoiceType = 'ASC',$unpaid=0)
    {
        $model = $this->model->forMe()->with('order')
            ->where(function ($query) use ($searchData) {
                if (@$searchData['iid'] != '') {
                    $query->where('IID', 'LIKE', $searchData['iid']);
                }

               if (@$searchData['date_from'] != '') {
                    $query->whereRaw("DATE(created_at) >= '" . \DateTime::createFromFormat('d/m/Y', urldecode($searchData['date_from']))->format("Y-m-d") . "'");
                }

                if (@$searchData['date_to'] != '') {
                    $query->whereRaw("DATE(created_at) <= '" . \DateTime::createFromFormat('d/m/Y', urldecode($searchData['date_to']))->format("Y-m-d") . "'");
                }


                if (@$searchData['status'] != '') {
                    $date= date('Y-m-d');
                    if(@$searchData['status'] == 'due'){
                        $query->where('issue_date','<',$date)->where('status', '=', 2);
                    }else{
                    $query->where('status', '=', $searchData['status']);
                    }
                }

            
                if (@$searchData['user_id'] != '') {
                    $query->where('user_id', '=', $searchData['user_id']);
                }
            })
           ->orderBy($invoiceBy, $invoiceType);//->paginate($items);
           
      
     
               return $model->get();
        
    }


    /**
     * get the invoices for the provided ids
     *
     * @param array $ids
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getIn(array $ids)
    {

        return $this->model->whereIn('id', $ids)->get();
    }

    public function updateBilling($id, $billingData)
    {
        $this->startTransaction();
        $invoiceModel = $this->getById($id);
        try {
            $invoiceModel->billing()->delete();
            $invoiceModel->billing()->save(new Billing($billingData));
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

    /**
     * @param $name the name used to check the duplicate record in the db
     * @return int
     */
    public function checkDuplicateInvoices($name, $id = 0)
    {
        //echo $email;
        if ($this->model->where('name', $name)->where('id', '!=', $id)->count()) {
            throw new ApplicationException('Invoice already exists');
        }
        //print_r(\DB::getQueryLog());
    }

    public function deleteInvoice($id)
    {
        $invoice = $this->getById($id);
        if (is_null($invoice)) {
            throw new ResourceNotFoundException('Invoice Not Found');
        }

        /*$name = $invoice->filename;
        @unlink('./uploads/invoices/'.$name);*/
        if ($invoice->selfDestruct()) {
            // print_r(DB::getQueryLog());
            return true;
        }

        return false;
    }
}