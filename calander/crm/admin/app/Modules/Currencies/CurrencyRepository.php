<?php

namespace App\Modules\Currencies;

use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Repos\EloquentRepository;
use Optimait\Laravel\Traits\CallbackForRequestTrait;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class CurrencyRepository extends EloquentRepository
{
    use CallbackForRequestTrait;
    public $validator;

    protected $insertedId;
    protected $optionsView;

    public function __construct(Currency $currency, CurrencyValidator $currencyValidator)
    {
        $this->model = $currency;
        $this->validator = $currencyValidator;
    }

    public function getPaginated($items = 10, $currencyBy = 'created_at', $currencyType = 'DESC')
    {
        return $this->model->orderBy($currencyBy, $currencyType)->paginate($items);
    }

    public function createCurrency($currencyData = array(), \Closure $c = null)
    {
        $currencyData = array_merge($currencyData, $this->processCallbackForRequest($c));

        $currency = parent::getNew($currencyData);
        if ($currency->save()) {
            event('currency.saved', array($currency, $currencyData, false));
            return $currency;
        }
        throw new ApplicationException("Cannot Add Currency Template.");
    }


    public function updateCurrency($id, $currencyData = array(), \Closure $c = null)
    {
        $currencyData = array_merge($currencyData, $this->processCallbackForRequest($c));
        $currency = $this->getById($id);
        $currency->fill($currencyData);
        if ($currency->save()) {
            event('currency.saved', array($currency, $currencyData));
            return $currency;
        }

        throw new ApplicationException("Cannot Add Currency.");
    }


    public function deleteCurrency($id)
    {
        $currency = $this->getById($id);
        if (is_null($currency)) {
            throw new ResourceNotFoundException('Currency Not Found');
        }

        /*$name = $currency->filename;
        @unlink('./uploads/inventories/'.$name);*/
        if ($currency->selfDestruct()) {
            // print_r(DB::getQueryLog());
            return true;
        }

        return false;
    }
}