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

use App\Modules\Laser;
use App\Modules\Unpaid;
// changes 10/July/2019
use App\Modules\Currencies\Currency;
 

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

        //echo currency1(123);die;
        error_reporting(0);
        if (Input::get('search')) {

            if($_REQUEST['status']=='due'){
               $invoices = $this->invoices->getSearchedPaginated(\Input::all(), 50, Input::get('invoiceBy', 'created_at'), Input::get('invoiceType', 'DESC'));

               $invoices1 = $this->invoices->getSearchedPaginated1(\Input::all(), 50, Input::get('invoiceBy', 'created_at'), Input::get('invoiceType', 'DESC'));

             $oData1 = Order::join('invoices','invoices.order_id','=','orders.id')
                 ->whereIn('invoices.IID',$invoices1->pluck('IID'))
                ->where('invoices.status',2)->get();
            

            $oData2 = Order::join('invoices','invoices.order_id','=','orders.id')
                ->whereIn('invoices.IID',$invoices->pluck('IID'))
                ->where('invoices.status',1)->get();

            }else{
            $invoices = $this->invoices->getSearchedPaginated(\Input::all(), 10, Input::get('invoiceBy', 'created_at'), Input::get('invoiceType', 'DESC'));

            $invoices1 = $this->invoices->getSearchedPaginated1(\Input::all(), 10, Input::get('invoiceBy', 'created_at'), Input::get('invoiceType', 'DESC'));

            /********************************************/
            // $userId= $_GET['user_id'];
            // $InvoiceId= $_GET['iid'];
            
            
             $oData1 = Order::join('invoices','invoices.order_id','=','orders.id')
                 ->whereIn('invoices.IID',$invoices1->pluck('IID'))
                ->where('invoices.status',2)->get();
            

            $oData2 = Order::join('invoices','invoices.order_id','=','orders.id')
                ->whereIn('invoices.IID',$invoices1->pluck('IID'))
                ->where('invoices.status',1)->get();
            /*********************************************/

            }
            
        } else {
            $invoices = $this->invoices->getPaginated(10, Input::get('invoiceBy', 'created_at'), Input::get('invoiceType', 'DESC'));

            
            /******************************************/
            $oData1 = Order::join('invoices','invoices.order_id','=','orders.id')
                // ->where('invoices.user_id',$userId)
                ->where('invoices.status',2)->get();


            $oData2 = Order::join('invoices','invoices.order_id','=','orders.id')
                // ->where('invoices.user_id',$userId)
                ->where('invoices.status',1)->get();


            /*******************************************/
           
        }
        
        $uId= $invoices->pluck('user_id')->toArray();


            $currency=    \DB::table('users')

            ->leftjoin('currencies','currencies.id','=','users.currency_id')
            ->whereIn('users.id',$uId)
            ->get();
             

        //      echo '<pre>';print_r($currency);
        // die;
        //echo 'count'.count($invoices);die;
        $totalUnpaid=0;
        foreach($oData1 as $unPaidPrice){
            //echo '<pre>';print_r($unPaidPrice);
            $price=$unPaidPrice['price'];
            $shipPrice=$unPaidPrice['shipping_price'];
            $tax =$unPaidPrice['tax_percent'];
            $k=100;
             
            if($tax==NULL){
                $act=$price+$shipPrice;
                $totalAmt=$act+$price;
                $totalAmt=$price+$shipPrice;
                // echo  $price.'+'.$shipPrice.'='.$totalAmt; echo '<br>';
            }else{
                $act=$price+$shipPrice;
                $totalTax=$act*$tax/100;
                $totalAmt=$totalTax+$price;
                // echo  $price.'-'.$tax.'/'.$k.'='.$totalAmt; echo '<br>';
            }
            $totalUnpaid+=$totalAmt;
        }



        
        
        $totalpaid=0;
        foreach($oData2 as $paidPrice){
            //echo '<pre>';print_r($unPaidPrice);
            $price=$paidPrice['price'];
            $shipPrice=$paidPrice['shipping_price'];
            $tax =$paidPrice['tax_percent'];
            $k=100;
             
            if($tax==NULL){
                $act=$price+$shipPrice;
                $totalAmt=$act+$price;
                $totalAmt=$price+$shipPrice;
                // echo  $price.'+'.$shipPrice.'='.$totalAmt; echo '<br>';
            }else{
                $act=$price+$shipPrice;
                $totalTax=$act*$tax/100;
                $totalAmt=$totalTax+$price;
                // echo  $price.'-'.$tax.'/'.$k.'='.$totalAmt; echo '<br>';
            }
            $totalpaid+=$totalAmt;
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
        
        // new changes 8 May order_id
        // get variant id in order status table
        $items= Item::where('order_id',$invoice['order_id'])->get();
        foreach($items as $item){

            $variant= Variant::where('id',$item['variant_id'])->first();
            $order= Order::where('id',$item['order_id'])->first();
            
            //$vqty= $item['qty']-$item['total_required'];
            if($status==1 || $status==2){

                 if($status==2){
                    $invoice = Invoice::where('id',$id)->first();
                    
                    $laser= Laser::where('invoice_id',$invoice['IID'])->first();
                    //echo $laser['userId'];
                    //echo $laser['paid_price'];

                    $Unpaid= Unpaid::where('user_id',$laser['userId'])->first();
                    //if(!empty($Unpaid->total_amt)){
                    //$Unpaid->total_amt= $Unpaid->total_amt-$laser['paid_price'];
                    //$Unpaid->update();

                    $delete= Laser::where('invoice_id',$invoice['IID'])->delete();
                  // }
                    //echo '<pre>';print_r($item['price']);

                   
                }

                // if($item['current_stock'] ==0){
                //     $variant->total_required= $variant->total_required - $item['qty'];
                // }else{
                // $currentRequired = $item['total_required'];
                 
                // //die;
                // $variant->qty= $variant->qty - ($item['qty'] - $item['total_required']);
                // $variant->total_required= $variant->total_required - $currentRequired;

                // }
                $variant->total_required=0;
                $variant->update();
                $order->status=4;
                $order->update();
            }else{
                //echo $item['current_stock'];die;
                //$currentStock= $item['current_stock']; echo '<br>';
                 

                //echo '<>'.count($item);die;
                // if($item['current_stock'] ==0){
                //     $variant->total_required= $variant->total_required + $item['qty'];
                // }else{

                // $currentRequired = $item['total_required'];
                // $tt= $variant->qty + ($item['qty'] - $item['total_required']);
                // //die;
                // $variant->qty= $tt;
                // $variant->total_required= $variant->total_required + $currentRequired;
                
                // }
                $variant->total_required=0;
                $variant->update();
                $order->status=2;
                $order->update();
                }

               
        }
            //update data in order_status table
        
        //die;



        // end new changes here 
        if (is_null($invoice)) {
            throw new ResourceNotFoundException('Invoice Not Found');
        }
        //echo $status;;die;
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
