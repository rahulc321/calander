<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Authority;
use App\Http\Controllers\Controller;
use App\Modules\Currencies\CurrencyRepository;
use Exception;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class CurrenciesController extends Controller
{
    use ResetsPasswords;
    private $currencies;


    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->middleware(['auth.onlyAdmin'], ['except' => ['getItemForOrder', 'getVariantsAjax']]);
        $this->currencies = $currencyRepository;
    }

    /**
     * Display a listing of the resource.
     * GET /currencycurrencies
     *
     * @return Response
     */
    public function index()
    {
        Authority::authorize('list', 'currencies');
        /*for ajax request*/
        if (\Request::ajax()) {
            return $this->getList();
        }
        return view('webpanel.currencies.index');
    }

    public function getList($id = 0)
    {
        $currencies = $this->currencies->getPaginated(10, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));
        /*echo 'hello world';*/

        return response()->json(array(
            'data' => view('webpanel.currencies.partials.list', compact('currencies'))->render(),
            'pagination' => sysView('includes.pagination', ['data' => $currencies])->render()
        ));
    }

    /**
     * Show the form for creating a new resource.
     * GET /currencies/create
     *
     * @return Response
     */
    public function create()
    {
        Authority::authorize('add', 'currencies');
        return sysView('currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /currencies
     *
     * @return Response
     */
    public function store()
    {
        Authority::authorize('add', 'currencies');
        //provide the validation data
        $this->currencies->validator->with(Input::all())->isValid();

        /*$this->currencies->checkDuplicateCurrencies(Input::get('email'));*/
        /*pd(Input::file('photo'));*/

        if($currency = $this->currencies->createCurrency(Input::all())){
            return response()->json(array(
                'notification' => ReturnNotification(array('success' => 'Created Successfully')),
                'redirect' => sysRoute('currencies.index')
            ));
        }
       throw new ApplicationException("Something went wrong.");
    }

    /**
     * Display the specified resource.
     * GET /currencies/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /currencies/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        Authority::authorize('edit', 'currencies');
        $currency = $this->currencies->getById($id);
        if (is_null($currency)) {
            throw new ResourceNotFoundException('Currency not Found');
        }
        return sysView('currencies.partials.edit-modal', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /currencies/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        Authority::authorize('edit', 'currencies');
        //set up validation data
        /*$id = decryptIt($id);*/
        $this->currencies->validator->with(Input::all())->isValid();


        if ($currency = $this->currencies->updateCurrency($id, Input::all())) {

            return response()->json(array(
                'notification' => ReturnNotification(array('success' => 'Currency Info Saved Successfully')),
                'redirect' => route('webpanel.currencies.index')
            ));

        }

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /currencies/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    /*
     * Delete the currencies along with their related data like permissions.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function getDelete($id)
    {
        Authority::authorize('delete', 'currencies');
        if ($this->currencies->deleteCurrency($id)) {
            echo 1;
        } else {
            throw new Exception('Cannot delete Currency at the moment');
        }
    }
}