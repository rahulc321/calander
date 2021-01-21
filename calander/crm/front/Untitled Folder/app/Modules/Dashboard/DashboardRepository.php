<?php

namespace App\Modules\Invoices;

use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Repos\EloquentRepository;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

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

    public function getPaginated($items = 10, $invoiceBy = 'created_at', $invoiceType = 'DESC')
    {
        //return $this->model->forMe()->with('order')->orderBy($invoiceBy, $invoiceType)->paginate($items);
        
        $model = $this->model->forMe()->with('order')->orderBy($invoiceBy, $invoiceType);
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
        });
        return is_null($items) ? $model->get() : $model->paginate($items);
    }

    /**
     * Description
     */
    public function getSearchedPaginated($searchData, $items = 10, $invoiceBy = 'inventory_id', $invoiceType = 'ASC')
    {
        echo $model = $this->model->forMe()->with('order')
            ->where(function ($query) use ($searchData) {
                if (@$searchData['iid'] != '') {
                    $query->where('IID', 'LIKE', $searchData['iid']);
                }

                if (@$searchData['date_from'] != '') {
                   $query->whereRaw("DATE(issue_date) >= '" . \DateTime::createFromFormat('d/m/Y', urldecode($searchData['date_from']))->format("Y-m-d") . "'");
                    
                }

                if (@$searchData['date_to'] != '') {
                    $query->whereRaw("DATE(issue_date) <= '" . \DateTime::createFromFormat('d/m/Y', urldecode($searchData['date_to']))->format("Y-m-d") . "'");
                }


                if (@$searchData['status'] != '') {
                    $query->where('status', '=', $searchData['status']);
                }

                if (@$searchData['due'] != '') {
                    $query->where('status', '=', Invoice::STATUS_UNPAID);
                }
                if (@$searchData['user_id'] != '') {
                    $query->where('created_by', '=', $searchData['user_id']);
                }
               // if (@$searchData['due_date'] != ''
               //     || @$searchData['amount_min'] != ''
                //    || @$searchData['amount_max'] != ''
                //    || @$searchData['due'] != ''
                //) {
                 //   $query->whereHas('order', function ($q) use ($searchData) {
                  //      if (@$searchData['due_date'] != '') {
                    //        $q->whereRaw("DATE(due_date) = '" . $searchData['due_date'] . "'");
                      //  };

                    //    if (@$searchData['amount_min'] != '') {
                     //       $q->where('price', '>=', $searchData['amount_min']);
                      //  }

                //        if (@$searchData['amount_max'] != '') {
                  //          $q->where('price', '<=', $searchData['amount_max']);
                    //    }

                      //  if (@$searchData['due'] != '') {
                        //    $q->whereRaw("DATE(CURDATE()) > DATE(due_date)");
                    //    }

                //    });
                //}
            })
           ->orderBy($invoiceBy, $invoiceType);
           return is_null($items) ? $model->get() : $model->paginate($items);
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