<?php
namespace App\Modules\Withdraws;


use Ddeboer\DataImport\Reader\CsvReader;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Repos\EloquentRepository;
use Optimait\Laravel\Traits\CallbackForRequestTrait;
use Optimait\Laravel\Traits\UploaderTrait;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class WithdrawRepository extends EloquentRepository
{
    use CallbackForRequestTrait, UploaderTrait;
    public $validator;

    public function __construct(Withdraw $withdraws, WithdrawValidator $withdrawsValidator)
    {
        $this->model = $withdraws;
        $this->validator = $withdrawsValidator;
    }

    public function getSearchedPaginated($data, $items = 10, $orderBy = 'title', $orderType = 'ASC', $where = null)
    {
        $model = $this->model->where('id', '!=', 0)->with('source');

        if (!is_null($where) && is_callable($where)) {
            $model->where($where);
        }
        $model->where(function ($q) use ($data) {
            if (@$data['name']) {
                $q->where(function ($q) use ($data) {
                    $q->orWhere('full_name', 'LIKE', $data['name'] . '%');
                });
            }
            if (@$data['source']) {
                $q->where('withdraws_source_id', '=', $data['source']);
            }
        });
        return $model->orderBy($orderBy, $orderType)->paginate($items);
    }

    public function getPaginated($items = 10, $orderBy = 'title', $orderType = 'ASC', $where = null)
    {
        $model = $this->model->where('id', '!=', 0)->with('creator')->forMe();

        if (!is_null($where) && is_callable($where)) {
            $model->where($where);
        }
        return $model->orderBy($orderBy, $orderType)->paginate($items);
    }


    public function createWithdraws($withdrawsData = array(), \Closure $c = null)
    {
        $withdrawsData = array_merge($withdrawsData, $this->processCallbackForRequest($c));
        $withdraws = parent::getNew($withdrawsData);
        $withdraws->WID = "WIT-".rand(9999, 999999).time();
        if ($withdraws->save()) {
            event('withdraw.saved', array($withdraws, $withdrawsData, false));
            return $withdraws;
        }
        throw new ApplicationException("Cannot Add Withdraws Template.");
    }


    public function updateWithdraws($id, $withdrawsData = array(), \Closure $c = null)
    {
        $withdrawsData = array_merge($withdrawsData, $this->processCallbackForRequest($c));
        $withdraws = $this->getById($id);
        $withdraws->fill($withdrawsData);
        if ($withdraws->save()) {
            event('withdraw.saved', array($withdraws, $withdrawsData));
            return $withdraws;
        }

        throw new ApplicationException("Cannot Add Withdraws.");
    }


    public function deleteWithdraws($id)
    {
        $withdraws = $this->getById($id);
        if (is_null($withdraws)) {
            throw new ResourceNotFoundException('Withdraws Not Found');
        }

        /*$name = $withdraws->filename;
        @unlink('./uploads/inventories/'.$name);*/
        if ($withdraws->selfDestruct()) {
            // print_r(DB::getQueryLog());
            return true;
        }

        return false;
    }
}