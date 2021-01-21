<?php
namespace App\Http\Controllers\Admin;

use App\Helpers\Authority;
use App\Http\Controllers\Controller;
use App\Modules\Withdraws\Withdraw;
use App\Modules\Withdraws\WithdrawRepository;
use Exception;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Exceptions\NotAuthorizedException;
use Optimait\Laravel\Services\Email\EmailService;
use Optimait\Laravel\Services\PdfExport\PdfExportService;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use View;

class WithdrawsController extends Controller
{
    use ResetsPasswords;
    private $withdraws;


    public function __construct(WithdrawRepository $withdrawRepository)
    {
        if(auth()->user()->isCustomer()){
            throw new NotAuthorizedException("Not allowed");
        }
        $this->withdraws = $withdrawRepository;
    }

    /**
     * Display a listing of the resource.
     * GET /withdrawwithdraws
     *
     * @return Response
     */
    public function index()
    {
        Authority::authorize('list', 'withdraws');
        /*for ajax request*/
        if (\Request::ajax()) {
            return $this->getList();
        }
        return view('webpanel.withdraws.index');
    }

    public function getList($id = 0)
    {
        $withdraws = $this->withdraws->getPaginated(10, Input::get('orderBy', 'id'), Input::get('orderType', 'ASC'), function ($q) {
            $searchData = Input::all();
            if (@$searchData['search']) {

                if (@$searchData['user_id']) {
                    $q->where('created_by', '=', $searchData['user_id']);
                }

                if (@$searchData['status']) {
                    $q->where('status', '=', $searchData['status']);
                }

                if (@$searchData['date_from']) {
                    $q->whereRaw(\DB::raw("DATE(created_at) >= '" . $searchData['date_from'] . "'"));
                }
                if (@$searchData['date_to']) {
                    $q->whereRaw(\DB::raw("DATE(created_at) <= '" . $searchData['date_to'] . "'"));
                }
            }
        });
        /*echo 'hello world';*/

        return response()->json(array(
            'data' => view('webpanel.withdraws.partials.list', compact('withdraws'))->render(),
            'pagination' => sysView('includes.pagination', ['data' => $withdraws])->render()
        ));
    }

    /**
     * Show the form for creating a new resource.
     * GET /withdraws/create
     *
     * @return Response
     */
    public function create()
    {
        Authority::authorize('add', 'withdraws');
        return sysView('withdraws.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /withdraws
     *
     * @return Response
     */
    public function store()
    {
        Authority::authorize('add', 'withdraws');
        //provide the validation data
        $this->withdraws->validator->with(Input::all())->isValid();

        if (Input::get('amount') < config('currency.minBalance')) {
            throw new ApplicationException("Amount must be higher than minimun balance.");
        }

        if(Input::get('amount') > decryptIt(Input::get('cal_val'))){
            throw new ApplicationException("Your request amount exceeded available amount.");
        }

        /*$this->withdraws->checkDuplicateWithdraws(Input::get('email'));*/
        /*pd(Input::file('photo'));*/

        $withdraw = $this->withdraws->createWithdraws(Input::all());
        //finally add the withdraw
        /*var_dump($u);
        die();*/

        return response()->json(array(
            'notification' => ReturnNotification(array('success' => 'Created Successfully')),
            'redirect' => sysRoute('withdraws.index')
        ));


    }

    /**
     * Display the specified resource.
     * GET /withdraws/{id}
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
     * GET /withdraws/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        Authority::authorize('edit', 'withdraws');
        $id = decrypt($id);
        $withdraw = $this->withdraws->getById($id);
        if (is_null($withdraw)) {
            throw new ResourceNotFoundException('Withdraw not Found');
        }
        return sysView('withdraws.edit', compact('withdraw'));
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /withdraws/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    /*
     * Delete the withdraws along with their related data like permissions.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function getDelete($id)
    {
        Authority::authorize('delete', 'withdraws');
        if ($this->withdraws->deleteWithdraw(decryptIt($id))) {
            echo 1;
        } else {
            throw new Exception('Cannot delete Withdraw at the moment');
        }
    }


    public function postToggleStatus($id)
    {
        $id = decryptIt(urldecode(Input::get('withdraw_id')));

        $withdraw = $this->withdraws->getById($id);
        if (is_null($withdraw)) {
            throw new ResourceNotFoundException('Withdraw not Found');
        }
        $withdraw->status = Input::get('status');
        $withdraw->remarks = Input::get('remarks');
        $withdraw->save();
        event('withdraw.status-changed', [$withdraw]);
        return redirect()->back()->with(['success' => 'Changed']);
    }

    public function getDownloadAll(PdfExportService $exportService){
        $withdraws = $this->withdraws->getPaginated(100000000, Input::get('orderBy', 'id'), Input::get('orderType', 'ASC'), function ($q) {
            $searchData = Input::all();
            if (@$searchData['search']) {

                if (@$searchData['user_id']) {
                    $q->where('created_by', '=', $searchData['user_id']);
                }

                if (@$searchData['status']) {
                    $q->where('status', '=', $searchData['status']);
                }

                if (@$searchData['date_from']) {
                    $q->whereRaw(\DB::raw("DATE(created_at) >= '" . $searchData['date_from'] . "'"));
                }
                if (@$searchData['date_to']) {
                    $q->whereRaw(\DB::raw("DATE(created_at) <= '" . $searchData['date_to'] . "'"));
                }
            }
        });

        return $exportService->setName('Withdraws-'.date("Y-m-d").".pdf")
            ->load(view('pdf.withdraws.all', compact('withdraws')))
            ->download();

    }

}