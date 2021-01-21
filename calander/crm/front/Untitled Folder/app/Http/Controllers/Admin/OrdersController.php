<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Order;
use App\Modules\Orders\OrderRepository;
use App\Modules\Products\ProductRepository;
use App\Modules\Products\Variant;
use App\Modules\Products\Product;
use App\Modules\Orders\Item;
use App\Models\Payment;
use App\Http\Requests;

use Exception;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Services\PdfExport\PdfExportService;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class OrdersController extends Controller
{
    private $orders;


    public function __construct(OrderRepository $orderRepository)
    {
        $this->orders = $orderRepository;
    }

    /*
     * Display a listing of the resource.
     * GET /orderorders
     *
     * @return Response
     */

    public function index()
    {
        
        if (\Request::ajax()) {
            return $this->getList();
        }
        if (Input::get('search')) {
            $orders = $this->orders->getSearchedPaginated(\Input::all(), null, Input::get('orderBy', 'created_at'), Input::get('orderType', 'DESC'));
        } else {
            $orders = $this->orders->getPaginated(null, Input::get('orderBy', 'created_at'), Input::get('orderType', 'DESC'));
        }
        return sysView('orders.index', compact('orders'));
    }

    public function getList($id = 0)
    {
        if (Input::get('search')) {
            $orders = $this->orders->getSearchedPaginated(\Input::all(), 10, Input::get('orderBy', 'created_at'), Input::get('orderType', 'DESC'));
        } else {
            $orders = $this->orders->getPaginated(10, Input::get('orderBy', 'created_at'), Input::get('orderType', 'DESC'));
        }
        return response()->json(array(
            'data' => sysView('orders.partials.list', compact('orders'))->render(),
            'pagination' => sysView('includes.pagination', ['data' => $orders])->render(),
        ));
    }

    public function orderHistory(){
        // select * from `orders` where `created_by` = 349 and `status` = 2 order by `created_at1` desc limit 2 offset 0



         @$orders = Order::where('created_by',\Auth::user()->id)->orderBy('created_at', 'DESC')->where('price','!=',0.00)->where('status','!=','')->paginate(13);

        //$orders = $this->orders->getPaginated(2, Input::get('orderBy', 'created_at'), Input::get('orderType', 'DESC'))->pluck('id');

        @$orders1 = Order::where('created_by',\Auth::user()->id)->orderBy('created_at', 'DESC')->where('price','!=',0.00)->where('status','!=','')->paginate(13);
        $all = array();
        foreach(@$orders as $orderId){

            //echo '<pre>';print_r($orderId->id);
            $all[]  = $this->orders->getById($orderId->id);

        }

       
       //$productFooter = Product::where('id','!=',0)->where('deleted_at',null)->orderBy('name','asc')->paginate(6);


        // echo '<pre>';print_r(count($all));die;
        return view('webpanel.front.order-history')->with('order',$all)->with('orders1',$orders1);
    }

    /**
     * Show the form for creating a new resource.
     * GET /orders/create
     *
     * @return Response
     */
    public function create(ProductRepository $repository)
    {
        if (Input::get('filter')) {
            $products = $repository->getSearchedPaginated(Input::all(), 100, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));
        } else {
            $products = $repository->getPaginated(100, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));

        }
        return sysView('orders.create', compact('products'));
    }


    // public function getCart()
    // {
    //     $order = Order::Current();
         
    //     return sysView('front.checkout', compact('order'));
    // }
    
    
    public function getCart()
    {
        $order = Order::Current();
        $order_itemData= Item::where('order_id',$order['id'])->first();
        // echo $order_itemData['variant_id']['product_id'].'<br>';
        // echo $order_itemData['variant_id'];die;
        $variantData= Variant::where('id',$order_itemData['variant_id'])->where('product_id',$order_itemData['product_id'])->first();
        // echo $variantData['qty'];die;
        return sysView('front.checkout', compact('order'))->with('variantData',$variantData);
    }
    
    public function paypalTransaction(Request $request){
        $uData= $request->all();
        echo '<pre>';print_r($uData);die;
        $order = Order::Current();

        echo '<pre>';print_r($_REQUEST);die;
        $oid= $order->OID; 
        $paymentStatus= $_POST['paymentStatus'];
        $transactionId= $_POST['transactionId'];
        $currency= $_POST['currency'];
        $amount= $_POST['amount'];


        $payment = new Payment();
        $payment->userId =\Auth::user()->id;
        $payment->transactionId =$transactionId;
        $payment->paymentStatus =$paymentStatus;
        $payment->currency =$currency;
        $payment->amount =$amount;
        $payment->orderId =$oid;
        $payment->save();
        echo 1;




    }

    public function postCart()
    {
        
        echo Input::get('id');

        $upadteCart= Item::where('id',Input::get('id'))->first();
        $upadteCart->qty= Input::get('qty');
        $upadteCart->save();
        echo 1;

    }

    

    public function putShip($id)
    {
        $items= Item::where('order_id',decryptIt($id))->get();
        // echo 'count'.count($item);echo '<br>';
        // echo decryptIt($id);die;
        //echo 'sdsa';die;
        if(Input::get('due_date')){
            $due_date = \DateTime::createFromFormat('d/m/Y', Input::get('due_date'))->format("Y-m-d");
            Input::merge(['due_date' => $due_date]);
        }

        $this->orders->shipCart(decryptIt($id), Input::all());
        // ship code
        foreach($items as $item){


        $product_id= $item->product_id;
        $variant_id= $item->variant_id;
        $product_qty= $item->qty;
        $totalRequired= $item->total_required;
        // get all data from varent table 
        $variant= Variant::where('id',$item['variant_id'])->first();
        $reqty= $variant->total_required;
        $order= Order::where('id',$item['order_id'])->first();


        if($variant->total_required > $product_qty){
            $variant->total_required = abs($variant->total_required-$product_qty);
            $variant->update();

        }else{
            $variant->total_required =0;
            $variant->update();

        }
        // if($variant->total_required > 0){

        //     $updateReq = Variant::where('id',$variant_id)->first();
        //     $updateReq->total_required = $updateReq->total_required-$totalRequired;
        //     $updateReq->update();

        // }

         }
        /*
        if($reqty >= $product_qty){
            $currentReqQty = $reqty - $product_qty;
            $updateReq = Variant::where('id',$variant_id)->first();
            $updateReq->total_required = $currentReqQty;
            $updateReq->update();
          } else {
            $currentReqQty = $reqty - $product_qty;
            $updateReq = Variant::where('id',$variant_id)->first();
            $updateReq->total_required = $currentReqQty;
            $updateReq->update();
          }
        */
        
        return redirect()->back()->with(['success' => Input::get('updateQty') ? 'Updated' : 'Shipped']);
    }

    public function putRefund($id)
    {
        $this->orders->refundCart(decryptIt($id), Input::all());
        return redirect()->back()->with(['success' => 'Refund Request Sent']);
    }

    /*
     * Store a newly created resource in storage.
     * POST /orders
     *
     * @return Response
     */
    public function postAddToCart()
    {
        // if(!empty(\Auth::user())){ 
        if (empty(Input::get('id')) || empty(Input::get('variant_id'))){
            throw new ApplicationException("Please choose the color.");
        }
        $id = (Input::get('variant_id'));

        if ($this->orders->addToCart($id, Input::get('qty'))) {
            // return response()->json(array(
            //     'notification' => ReturnNotification(array('success' => 'Added To Cart'))
                
            // ));
            //echo 'hey';

            return redirect(url('orders/cart/xl'));
        }
        throw new ApplicationException('You have Successfully added');
        // }else{
        //   return redirect('/user-login'); 
        // }
    }
    
     public function postAddToCart2()
    {
       // if(!empty(\Auth::user())){ 
        if (empty(Input::get('id')) || empty(Input::get('variant_id'))){
            throw new ApplicationException("Please choose the color.");
        }
        $id = (Input::get('variant_id'));

        if ($this->orders->addToCart($id, Input::get('qty'))) {
            // return response()->json(array(
            //     'notification' => ReturnNotification(array('success' => 'Added To Cart'))
                
            // ));
            //echo 'hey';

            return redirect(url('orders/cart/xl'));
        }
        throw new ApplicationException('You have Successfully added');
        // }else{
        //   return redirect('/user-login'); 
        // }
    }

    public function postAddToCart2Backup()
    {
        // echo 'hi';die;
        // if(!empty(\Auth::user())){ 
        if (empty(Input::get('id')) || empty(Input::get('variant_id'))){
            throw new ApplicationException("Please choose the color.");
        }
        $id = (Input::get('variant_id'));

        if ($this->orders->addToCart($id, Input::get('qty'))) {
            // return response()->json(array(
            //     'notification' => ReturnNotification(array('success' => 'Added To Cart'))
                
            // ));
            //echo 'hey';
        }
        throw new ApplicationException('You have Successfully added');
        // }else{
        //   return redirect('/user-login'); 
        // }
    }

    public function getPlace()
    {


        if (!session(\App\Modules\Orders\Order::SESSION_KEY)) {
            throw new ApplicationException("No Order Placed");
        }
        $order = Order::Current();
        if ($order->place()) {
            // return redirect()->route('webpanel.orders.show', encryptIt($order->id))->with(['success' => 'Order Placed']);
        //    \Session::flash('message', 'You Have Successfully Order');
            throw new ApplicationException("Congratulations!! Your Order has been Placed Successfully");
        }
        throw new ApplicationException("Cannot place you order at the moment. Please try again later");
    }

    public function putPlaceForDealer()
    {   

        if (!session(\App\Modules\Orders\Order::SESSION_KEY)) {
            throw new ApplicationException("No Order Placed");
        }
        $order = Order::Current();

        if ($order->place(Input::get('user_id'))) {
            return redirect()->route('webpanel.orders.show', encryptIt($order->id))->with(['success' => 'Order Placed']);
        }
        throw new ApplicationException("Cannot place you order at the moment. Please try again later");
    }

    public function postReplace(){
        
        if(!Input::get('order_id')){
            throw new ApplicationException("Invalid Access");
        }
        $order = $this->orders->requireById(Input::get('order_id'));
        foreach(Order::Current()->items as $item){
            $order->addToCart(Variant::find($item->variant_id), $item->qty);
        }
        session()->forget(Order::SESSION_KEY);
        Order::Current()->selfDestruct();
        return redirect()->route('webpanel.orders.show', encryptIt($order->id))->with(['success' => 'Order Placed']);
    }

    public function getFinished($id)
    {
        $id = decrypt($id);
        $order = $this->orders->getById($id);
        if (is_null($order)) {
            throw new ResourceNotFoundException('Order not Found');
        }
        return sysView('orders.finished', compact('order'));
    }

    /*
     * Display the specified resource.
     * GET /orders/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {   
        $id = decrypt($id);
        $order = $this->orders->getById($id);
        if (is_null($order)) {
            throw new ResourceNotFoundException('Order not Found');
        }
        return sysView('orders.show', compact('order'));
    }

    /*
     * Show the form for editing the specified resource.
     * GET /orders/{id}/edit
     *
     * @param  int $id
     * @return Response
     */

    public function edit($id)
    {
        $id = decrypt($id);
        $order = $this->orders->getById($id);
        if (is_null($order)) {
            throw new ResourceNotFoundException('Order Not Found');
        }
        return sysView('orders.partials.edit-modal', compact('order'));
    }

    /*
     * Remove the specified resource from storage.
     * DELETE /orders/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    /*
     * Delete the orders along with their related data like permissions.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function getDelete($id)
    {   
        
        $id = decrypt($id);
        
        // 24 april changes
        $items= Item::where('order_id',$id)->get();
        
        foreach($items as $item){


        $product_id= $item->product_id;
        $variant_id= $item->variant_id;
        $product_qty= $item->qty;
        $totalRequired= $item->total_required;
         
        $updateReq = Variant::where('id',$variant_id)->first();

        if($updateReq->qty >= $updateReq->total_required){
            $updateReq->qty= $updateReq->qty+$product_qty;
            $updateReq->update();
        }else{
         
           if($product_qty > $updateReq->total_required){
                if($updateReq->total_required > $updateReq->qty){
                    $updateReq->qty=$updateReq->qty+abs($item->qty-$updateReq->total_required);
                    $updateReq->total_required=0;
                    $updateReq->update();

                    
                }else{
                $updateReq->qty=$updateReq->qty+abs($item->qty-$updateReq->total_required);
                $updateReq->total_required= $updateReq->total_required- abs($item->qty-$updateReq->total_required);
                $updateReq->update();
                }
                 
            }else{

               
           $updateReq->total_required = abs($updateReq->total_required - $totalRequired);
           $updateReq->update();
           }
        }
        
        // if($totalRequired > 0){
            
        //     $updateReq = Variant::where('id',$variant_id)->first();
        //     if($updateReq->total_required > 0){
        //     //echo 'hey';die;
        //     $updateReq->total_required = abs($updateReq->total_required-$totalRequired);
        //     $updateReq->qty=$updateReq->qty+abs($item->qty-$totalRequired);
        //     $updateReq->update();
        //     }else{
        //         if($updateReq->qty >= $updateReq->total_required){
        //             $updateReq->qty=$updateReq->qty+$product_qty;
        //             $updateReq->update();

        //         }else{
        //         $updateReq->total_required = 0;
        //        // $updateReq->qty=$updateReq->qty+abs($item->qty-$totalRequired);
        //         $updateReq->update();
        //          }
        //     }

        // }else{
            
            
        //     $updateReq = Variant::where('id',$variant_id)->first();
        //     if($updateReq->qty >= $updateReq->total_required){

        //     $updateReq->qty=$updateReq->qty+$product_qty;
        //     $updateReq->update(); 
        //     }
        // }

         }
         // end code
        if ($this->orders->deleteOrder($id)) {
            echo 1;
        } else {
            throw new Exception('Cannot delete Order at the moment');
        }
    }

    public function getDeleteCartItem($id)
    {
        //echo $id = decrypt($id);die;
        if ($this->orders->deleteCartItem($id)) {
            return redirect(url('orders/cart/xl'));
             
             throw new Exception('You have successfully delete item.');

        } else {
            throw new Exception('Cannot delete Order at the moment');
        }
    }

    public function getApprove($id)
    {
        $id = decrypt($id);
        $order = $this->orders->getById($id);
        if (is_null($order)) {
            throw new ResourceNotFoundException('Order not Found');
        }
        $order->approve();
        return redirect()->back()->with(['success' => 'Approved. Waiting for payment.']);
    }

    public function getPay($id)
    {
        $id = decrypt($id);
        $order = $this->orders->getById($id);
        if (is_null($order)) {
            throw new ResourceNotFoundException('Order Not Found');
        }
        $order->pay();
        return redirect()->back()->with(['success' => 'Paid']);
    }

    public function putDecline($id)
    {
        $id = decrypt($id);
        $order = $this->orders->getById($id);
        if (is_null($order)) {
            throw new ResourceNotFoundException('Order Not Found');
        }
        $order->decline(Input::get('remarks'));
        return redirect()->back()->with(['success' => 'Order Declined']);
    }


    public function getDownload(PdfExportService $exportService, $id)
    {
        $id = decrypt($id);
        $order = $this->orders->getById($id);
        if (is_null($order)) {
            throw new ResourceNotFoundException('Order Not Found');
        }
        return $exportService
            ->setName($order->OID . '.pdf')
            ->load(view('pdf.orders.details', compact('order'))->render())
            ->stream();
    }

    public function getDownloadRefund(PdfExportService $exportService, $id)
    {
        $id = decrypt($id);
        $order = $this->orders->getById($id);
        if (is_null($order)) {
            throw new ResourceNotFoundException('Order Not Found');
        }
        return $exportService
            ->setName($order->OID . '.pdf')
            ->load(view('pdf.orders.refund-details', compact('order'))->render())
            ->stream();
    }

    public function getDownloadAll(PdfExportService $exportService)
    {
        if (Input::get('search')) {
            $orders = $this->orders->getSearchedPaginated(\Input::all(), 1000000000, Input::get('orderBy', 'created_at'), Input::get('orderType', 'DESC'));
        } else {
            $orders = $this->orders->getPaginated(10000000000, Input::get('orderBy', 'created_at'), Input::get('orderType', 'DESC'));
        }
        return $exportService->setName('Orders-' . date("Y-m-d") . ".pdf")
            ->load(view('pdf.orders.all', compact('orders')))
            ->download();
    }

    public function getDeleteOrderedItem($id, $orderId)
    {
       //echo $id = decrypt($id);
        

        // new code here
        /*
        $item= Item::where('id',$id)->first();
        
        $product_id= $item->product_id;
        $variant_id= $item->variant_id;
        $product_qty= $item->qty;
        $totalRequired= $item->total_required;
        // get all data from varent table 
        //$variant= Variant::where('id',$item['variant_id'])->first();
        //$reqty= $variant->total_required;
        //$order= Order::where('id',$item['order_id'])->first();

        if($totalRequired > 0){

            $updateReq = Variant::where('id',$variant_id)->first();
            $updateReq->total_required = $updateReq->total_required-$totalRequired;
            $updateReq->update();

        }
*/

        if ($this->orders->deleteCartItem($id)) {
             
            $order = $this->orders->requireById(decryptIt($orderId));
            $order->updatePrice();
            return redirect()->back()->with(['success' => 'Deleted']);
        } else {
            throw new Exception('Cannot delete Order at the moment');
        }
    }

    public function commissions(){
        $orders = $this->orders->getForComission();
        return sysView('orders.commissions');
    }
}
