<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Orders\Order;
use App\Modules\Orders\OrderRepository;
use App\Modules\Products\ProductRepository;
use App\Modules\Products\Variant;
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


    public function getCart()
    {
        $order = Order::Current();
        return sysView('orders.cart', compact('order'));
    }

    public function postCart()
    {
        if (!Input::get('ids')) {
            throw new ApplicationException("Please check the item first");
        }
        if ($this->orders->updateCart(Input::all())) {
            return redirect(sysUrl('orders/cart/xl'))->with(['success' => 'Updated']);
        }
    }

    public function putShip($id)
    {
        if(Input::get('due_date')){
            $due_date = \DateTime::createFromFormat('d/m/Y', Input::get('due_date'))->format("Y-m-d");
            Input::merge(['due_date' => $due_date]);
        }

        $this->orders->shipCart(decryptIt($id), Input::all());
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
        if (!Input::get('id') || !Input::get('variant_id')) {
            throw new ApplicationException("Please choose the color.");
        }
        $id = (Input::get('variant_id'));

        if ($this->orders->addToCart($id, Input::get('qty'))) {
            return response()->json(array(
                'notification' => ReturnNotification(array('success' => 'Added To Cart')),
                'redirect' => Input::get('redirect_url', route('webpanel.orders.create'))
            ));
        }
        throw new ApplicationException('Cannot be added at the moment');
    }

    public function getPlace()
    {
        if (!session(\App\Modules\Orders\Order::SESSION_KEY)) {
            throw new ApplicationException("No Order Placed");
        }
        $order = Order::Current();
        if ($order->place()) {
            return redirect()->route('webpanel.orders.show', encryptIt($order->id))->with(['success' => 'Order Placed']);
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
        if ($this->orders->deleteOrder($id)) {
            echo 1;
        } else {
            throw new Exception('Cannot delete Order at the moment');
        }
    }

    public function getDeleteCartItem($id)
    {
        $id = decrypt($id);
        if ($this->orders->deleteCartItem($id)) {
            return redirect(sysUrl('orders/cart/xl'));
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
        $id = decrypt($id);
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
