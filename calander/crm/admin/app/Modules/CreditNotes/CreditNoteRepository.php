<?php

namespace App\Modules\CreditNotes;


use App\Modules\Products\Product;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Repos\EloquentRepository;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class CreditNoteRepository extends EloquentRepository
{
    public $validator;

    protected $insertedId;
    protected $optionsView;

    public function __construct(CreditNote $creditNote, CreditNoteValidator $creditNoteValidator)
    {
        $this->model = $creditNote;
        $this->validator = $creditNoteValidator;
    }

    public function getPaginated($items = 10, $orderBy = 'created_at', $orderType = 'DESC')
    {
        $model = $this->model->forMe()->with('items')->orderBy($orderBy, $orderType);

        return is_null($items) ? $model->get() : $model->paginate($items);
    }

    /**
     * Description
     */
    public function getSearchedPaginated($searchData, $items = 10, $orderBy = 'id', $orderType = 'ASC')
    {
        $model = $this->model->with('items')
            ->where(function ($query) use ($searchData) {

                if (@$searchData['date_from'] != '') {
                    $query->whereRaw("DATE(created_at) >= '" . $searchData['date_from'] . "'");
                }

                if (@$searchData['date_to'] != '') {
                    $query->whereRaw("DATE(created_at) <= '" . $searchData['date_to'] . "'");
                }

                if (@$searchData['status'] != '') {
                    $query->where('status', '=', $searchData['status']);
                }

                if (@$searchData['user_id'] != '') {
                    $query->where('user_id', '=', $searchData['user_id']);
                }
            })
            ->orderBy($orderBy, $orderType);


        return is_null($items) ? $model->get() : $model->paginate($items);
    }


    public function getRefundsPaginated($items = 10, $creditNoteBy = 'created_at', $creditNoteType = 'DESC')
    {
        return $this->model->forMe()->exceptShopping()->hasRefunds()->with('refundItems')->creditNoteBy($creditNoteBy, $creditNoteType)->paginate($items);
    }

    /**
     * get the creditNotes for the provided ids
     *
     * @param array $ids
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getIn(array $ids)
    {

        return $this->model->whereIn('id', $ids)->get();
    }

    public function addCreditNote($creditNoteData)
    {
        $creditModel = parent::getNew($creditNoteData);
        if ($creditModel->save()) {
            if (isset($creditNoteData['variant_id']) && !empty($creditNoteData['variant_id'])) {
                $price = 0;
                foreach ($creditNoteData['variant_id'] as $k => $variantId) {

                    if ($variantId == '') {
                        continue;
                    }
                    $product = Product::find($creditNoteData['product_id'][$k]);
                    if (!$product) {
                        continue;
                    }
                    $creditModel->items()->save(new Item([
                        'product_id' => $creditNoteData['product_id'][$k],
                        'variant_id' => $variantId,
                        'qty' => $creditNoteData['qty'][$k],
                        'price' => $product->price
                    ]));
                    $price += $product->price * $creditNoteData['qty'][$k];
                }
                if ($creditModel->user && $creditModel->user->shouldPayTax()) {
                    $creditModel->tax_percent = $creditModel->user->getTaxPercent();
                }
                $creditModel->total = $price;
                $creditModel->save();
                $this->addUserWalletAmount($price);
            }

            return true;
        }

        throw new ApplicationException("Something went wrong. Please contact support.");
    }
   public function addUserWalletAmount($price){
       DB::table('user_wallet')->insert(
    ['wallet_webid' => 'cid', 'wallet_amount' => '$price', 'wallet_created' =>'now()', 'wallet_active' => '1']
);
   }

    /*
     * @param $creditNoteData
     * @return bool
     */
    public function updateCreditNote($id, $creditNoteData)
    {
        $creditNoteModel = $this->getById($id);
        $creditNoteModel->fill($creditNoteData);
        if ($creditNoteModel->save()) {
            if (isset($creditNoteData['variant_id']) && !empty($creditNoteData['variant_id'])) {
                $creditNoteModel->items()->delete();
                foreach ($creditNoteData['variant_id'] as $k => $variantId) {
                    if ($variantId == '') {
                        continue;
                    }
                    $product = Product::find($creditNoteData['product_id'][$k]);
                    if (!$product) {
                        continue;
                    }
                    $creditNoteModel->items()->save(new Item([
                        'product_id' => $creditNoteData['product_id'][$k],
                        'variant_id' => $variantId,
                        'qty' => $creditNoteData['qty'][$k],
                        'price' => $product->price
                    ]));
                }
            }

            return $creditNoteModel;
        }

        throw new ApplicationException("Something went wrong.");


    }

    public function getInsertedId()
    {
        return $this->insertedId;
    }

    /*
     * @param $name the name used to check the duplicate record in the db
     * @return int
     */
    public function checkDuplicateCreditNotes($name, $id = 0)
    {
        //echo $email;
        if ($this->model->where('name', $name)->where('id', '!=', $id)->count()) {
            throw new ApplicationException('CreditNote already exists');
        }
        //print_r(\DB::getQueryLog());
    }

    public function deleteCreditNote($id)
    {
        $creditNote = $this->getById($id);
        if (is_null($creditNote)) {
            throw new ResourceNotFoundException('CreditNote Not Found');
        }

        /*$name = $creditNote->filename;
        @unlink('./uploads/creditNotes/'.$name);*/
        if ($creditNote->selfDestruct()) {
            // print_r(DB::getQueryLog());
            return true;
        }

        return false;
    }

    public function deleteCartItem($id)
    {
        $creditNoteItem = Item::find($id);
        if (is_null($creditNoteItem)) {
            throw new ResourceNotFoundException('Item Not Found');
        }
        /*$name = $creditNote->filename;
        @unlink('./uploads/creditNotes/'.$name);*/
        if ($creditNoteItem->selfDestruct()) {
            // print_r(DB::getQueryLog());
            return true;
        }

        return false;
    }

    public function getDue($userId)
    {
        return $this->model->approved()->where('user_id', '=', $userId)->get();
    }
}