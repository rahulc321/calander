<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\CreditNotes\CreditNoteRepository;
use App\Modules\Products\ProductRepository;
use App\Modules\Users\UserRepository;
use Exception;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Services\PdfExport\PdfExportService;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class CreditNotesController extends Controller
{
    private $creditNotes;


    public function __construct(CreditNoteRepository $creditNoteRepository)
    {
        /*$this->middleware('auth.notEmployee');
        $this->middleware('auth.admin', ['except' => ['index']]);*/
        $this->creditNotes = $creditNoteRepository;
    }

    /**
     * Display a listing of the resource.
     * GET /creditNotecreditNotes
     *
     * @return Response
     */
    public function index(UserRepository $userRepository)
    {
        /*for ajax request*/
        if (\Request::ajax()) {
            return $this->getList();
        }
        $selectedUser = false;

        if(Input::get('user_id')){
            $selectedUser = $userRepository->requireById(Input::get('user_id'));
        }
        if(auth()->user()->isCustomer()){
            $selectedUser = auth()->user();
        }

        /*$creditNotes = $this->creditNotes->getAllPaginated(10);*/
        //echo 'hello world';
        return sysView('creditnotes.index', compact('selectedUser'));
    }

    public function getList($id = 0)
    {
        if (Input::get('search')) {
            $creditNotes = $this->creditNotes->getSearchedPaginated(\Input::all(), 10, Input::get('orderBy', 'created_at'), Input::get('orderType', 'DESC'));
        } else {
            $creditNotes = $this->creditNotes->getPaginated(10, Input::get('orderBy', 'created_at'), Input::get('orderType', 'DESC'));
        }

        /*echo 'hello world';*/

        return response()->json(array(
            'data' => sysView('creditnotes.partials.list', compact('creditNotes'))->render(),
            'pagination' => sysView('includes.pagination', ['data' => $creditNotes])->render(),
        ));
    }

    /**
     * Show the form for creating a new resource.
     * GET /creditNotes/create
     *
     * @return Response
     */
    public function create(ProductRepository $repository)
    {

        return sysView('creditnotes.create', compact('products'));
    }

    /*
     * Store a newly created resource in storage.
     * POST /creditNotes
     *
     * @return Response
     */
    public function store()
    {
        $this->creditNotes->validator->with(Input::all())->isValid();

        if ($this->creditNotes->addCreditNote(Input::all())) {
            return response()->json(array(
                'notification' => ReturnNotification(array('success' => 'Created')),
                'redirect' => Input::get('redirect_url', route('webpanel.creditnotes.index'))
            ));
        }
        throw new ApplicationException('Cannot be added at the moment');
    }


    /**
     * Display the specified resource.
     * GET /creditNotes/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $id = decrypt($id);
        $creditNote = $this->creditNotes->getById($id);
        if (is_null($creditNote)) {
            throw new ResourceNotFoundException('CreditNote not Found');
        }
        return sysView('creditnotes.show', compact('creditNote'));

    }

    /**
     * Show the form for editing the specified resource.
     * GET /creditNotes/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $creditNote = $this->creditNotes->getById($id);
        if (is_null($creditNote)) {
            throw new ResourceNotFoundException('CreditNote not Found');
        }
        return sysView('creditnotes.edit', compact('creditNote'));
    }

    public function update($id)
    {
        $id = decryptIt($id);

        $this->creditNotes->validator->setDefault('edit')->isValid();

        if ($this->creditNotes->updateCreditNote($id, Input::all())) {
            return response()->json(array(
                'notification' => ReturnNotification(array('success' => 'Saved')),
                'redirect' => Input::get('redirect_url', route('webpanel.creditnotes.index'))
            ));
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /creditNotes/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    /*
     * Delete the creditNotes along with their related data like permissions.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function getDelete($id)
    {
        $id = decrypt($id);
        if ($this->creditNotes->deleteCreditNote($id)) {
            echo 1;
        } else {
            throw new Exception('Cannot delete CreditNote at the moment');
        }
    }


    public function getApprove($id)
    {
        $id = decrypt($id);
        $creditNote = $this->creditNotes->getById($id);
        if (is_null($creditNote)) {
            throw new ResourceNotFoundException('CreditNote not Found');
        }
        $creditNote->approve();
        return redirect()->back()->with(['success' => 'Approved.']);
    }

    public function getPay($id)
    {
        $id = decrypt($id);
        $creditNote = $this->creditNotes->getById($id);
        if (is_null($creditNote)) {
            throw new ResourceNotFoundException('CreditNote not Found');
        }
        $creditNote->pay();
        return redirect()->back()->with(['success' => 'Paid']);
    }

    public function putDecline($id)
    {
        $id = decrypt($id);
        $creditNote = $this->creditNotes->getById($id);
        if (is_null($creditNote)) {
            throw new ResourceNotFoundException('CreditNote Not Found');
        }
        $creditNote->decline(Input::get('remarks'));
        return redirect()->back()->with(['success' => 'CreditNote Declined']);
    }


    public function getDownload(PdfExportService $exportService, $id)
    {
        $id = decrypt($id);
        $creditNote = $this->creditNotes->getById($id);
        if (is_null($creditNote)) {
            throw new ResourceNotFoundException('CreditNote Not Found');
        }
        return $exportService
            ->setName('Kreditnota ' . $creditNote->created_at . '.pdf')
            ->load(view('pdf.creditnotes.details', compact('creditNote'))->render())
            ->stream();
    }

    public function getDownloadAll(PdfExportService $exportService)
    {
        if (Input::get('search')) {
            $creditNotes = $this->creditNotes->getSearchedPaginated(\Input::all(), 1000000000, Input::get('creditNoteBy', 'created_at'), Input::get('creditNoteType', 'DESC'));
        } else {
            $creditNotes = $this->creditNotes->getPaginated(10000000000, Input::get('creditNoteBy', 'created_at'), Input::get('creditNoteType', 'DESC'));
        }

        return $exportService->setName('CreditNotes-' . date("Y-m-d") . ".pdf")
            ->load(view('pdf.creditnotes.all', compact('creditNotes')))
            ->download();
    }


    public function getChangePaymentType($id, $paymentType)
    {
        $creditNote = $this->creditNotes->requireById(decryptIt($id));
        $creditNote->payment_type = $paymentType;
        $creditNote->save();

        return redirect()->back()->with(['success' => 'Payment Method Changed']);
    }

}
