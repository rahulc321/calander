<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Invoices\Invoice;
use App\Modules\Orders\Item;
use App\Modules\Products\Variant;
use App\Modules\Orders\Order;
use App\Modules\Invoices\InvoiceRepository;
use App\Modules\Products\ProductRepository;
use Exception;
use Input;
use Optimait\Laravel\Services\PdfExport\PdfExportService;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use View;

class InvoicesController extends Controller
{
    private $invoices;

    public function __construct(InvoiceRepository $invoiceRepository)
    {
        /*$this->middleware('auth.notEmployee');
        $this->middleware('auth.admin', ['except' => ['index']]);*/
        $this->invoices = $invoiceRepository;
    }

    /**
     * Display a listing of the resource.
     * GET /invoices
     *
     * @return Response
     */

    public function index()
    {
        if (Input::get('search')) {
            $invoices = $this->invoices->getSearchedPaginated(\Input::all(), 10, Input::get('invoiceBy', 'created_at'), Input::get('invoiceType', 'DESC'));
            $invoicesAll = $this->invoices->getSearchedPaginated(\Input::all(), 10, Input::get('invoiceBy', 'created_at'), Input::get('invoiceType', 'DESC'), 1);
        } else {
            $invoices = $this->invoices->getPaginated(10, Input::get('invoiceBy', 'created_at'), Input::get('invoiceType', 'DESC'));
            $invoicesAll = $this->invoices->getPaginated(10, Input::get('invoiceBy', 'created_at'), Input::get('invoiceType', 'DESC'),1);
        }
        $totalUnpaid = 0;
        $totalpaid = 0;
        $totalUnpaidAll = $invoicesAll->where('status', 2)->all();
        $totalPaidAll = $invoicesAll->where('status', 1)->all();
        
        if(count($totalUnpaidAll)>0) {
            foreach($totalUnpaidAll as $totalU){
                $totalUnpaid = $totalU->order->getTotalPrice() + $totalUnpaid;
            }
        }
        if(count($totalPaidAll)>0) {
            foreach($totalPaidAll as $totalP){
                $totalpaid = $totalP->order->getTotalPrice() + $totalpaid;
            }
        }
        return sysView('invoices.index', compact('invoices', 'totalUnpaid', 'totalpaid'));
    }


    public function getCommissions()
    {
        $data = Input::all();
        $invoices = $this->invoices->getForCommission(10, $data);
        $totalInvoices = $this->invoices->getForCommission(null, $data);
        return sysView('invoices.commissions', compact('invoices', 'totalInvoices'));
    }

    public function getList($id = 0)
    {
        $invoices = $this->invoices->getPaginated(Input::all(), 10, Input::get('orderBy', 'iid'), Input::get('orderType', 'ASC'));
        return response()->json(array(
            'data' => view('webpanel.invoices.partials.list', compact('invoices'))->render(),
            'pagination' => sysView('includes.pagination', ['data' => $invoices])->render()
        ));
    }

    /**
     * Show the form for creating a new resource.
     * GET /invoices/create
     *
     * @return Response
     */
    public function create(ProductRepository $repository)
    {
        if (Input::get('search')) {
            $products = $repository->getSearchedPaginated(Input::all(), 100, Input::get('invoiceBy', 'name'), Input::get('invoiceType', 'ASC'));
        } else {
            $products = $repository->getPaginated(100, Input::get('invoiceBy', 'name'), Input::get('invoiceType', 'ASC'));
        }
        /*session()->forget(Invoice::SESSION_KEY);*/
        return View::make('webpanel.invoices.create', compact('products'));
    }

    /*
     * Delete the invoices along with their related data like permissions.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function getDelete($id)
    {
        $id = decrypt($id);
        if ($this->invoices->deleteInvoice($id)) {
            echo 1;
        } else {
            throw new Exception('Cannot delete Invoice at the moment');
        }
    }

    public function getToggleStatus($id, $status)
    {
        $id = decrypt($id);

        $invoice = $this->invoices->getById($id);
        if (is_null($invoice)) {
            throw new ResourceNotFoundException('Invoice Not Found');
        }
        // new changes 19 April
        // get variant id in order status table
        $item= Item::where('order_id',$invoice['order_id'])->first();
        // get all data from varent table 
        $variant= Variant::where('id',$item['variant_id'])->first();
        $order= Order::where('id',$item['order_id'])->first();
        // $variant['qty']
        // echo '<pre>';print_r($item['qty']-$item['total_required']);die;
        // die;
        $vqty= $item['qty']-$item['total_required'];
        if($status==2 || $status==1){
            $variant->qty=$variant['qty']-$vqty;
            $variant->update();
            // update data in order table
            $order->status=4;
            $order->update();
        }else{
            
            $variant->qty=$variant->qty+$vqty;
            $variant->update();
            $order->status=2;
            $order->update();

            //update data in order_status table
        }
        //die;



        // end new changes here  
        $invoice->status = $status;
        $invoice->save();
        if ($invoice->isPaid()) {
            $invoice->order->pay();
        }

        if($invoice->isCancelled()){
            $invoice->commission_status = Invoice::STATUS_COMMISSION_CANCELLED;
            $invoice->save();
        }
        return redirect()->back()->with(['success' => 'Changed']);
    }


    public function getToggleCommissionStatus($id)
    {
        $id = decrypt($id);
        $invoice = $this->invoices->getById($id);
        if (is_null($invoice)) {
            throw new ResourceNotFoundException('Invoice Not Found');
        }
        $invoice->commission_status = $invoice->commission_status == Invoice::STATUS_COMMISSION_UNPAID ? Invoice::STATUS_COMMISSION_PAID : Invoice::STATUS_COMMISSION_UNPAID;
        $invoice->save();

        if ($invoice->isPaid()) {
            $invoice->order->pay();
        }
        return redirect()->back()->with(['success' => 'Commission status changed']);
    }

    public function getDownloadAll(PdfExportService $exportService)
    {
        if (Input::get('search')) {
            $invoices = $this->invoices->getSearchedPaginated(\Input::all(), 1000000000, Input::get('invoiceBy', 'created_at'), Input::get('invoiceType', 'DESC'));
        } else {
            $invoices = $this->invoices->getPaginated(1000000000, Input::get('invoiceBy', 'created_at'), Input::get('invoiceType', 'DESC'));
        }
        return $exportService->setName('Invoices-' . date("Y-m-d") . ".pdf")
            ->load(view('pdf.invoices.all', compact('invoices')))
            ->download();
    }

    public function getDownload(PdfExportService $exportService, $id)
    {
        $id = decrypt($id);
        $invoice = $this->invoices->getById($id);
        if (is_null($invoice)) {
            throw new ResourceNotFoundException('Invoice Not Found');
        }
        return $exportService
            ->setName('IID-'.$invoice->IID . '.pdf')
            ->load(view('pdf.orders.invoice', compact('order', 'invoice'))->render())
            ->stream();
    }

}
