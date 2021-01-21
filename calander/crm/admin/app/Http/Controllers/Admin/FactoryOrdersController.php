<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\FactoryOrders\FactoryOrder;
use App\Modules\FactoryOrders\FactoryOrderRepository;
use App\Modules\Products\ProductRepository;
use Exception;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Services\PdfExport\PdfExportService;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use View;

class FactoryOrdersController extends Controller
{
    private $factoryOrders;

    public function __construct(FactoryOrderRepository $factoryOrderRepository)
    {
        $this->factoryOrders = $factoryOrderRepository;
    }

    /*
     * Display a listing of the resource.
     * GET /factoryOrderfactoryOrders
     *
     * @return Response
     */
    public function index()
    {
        if (\Request::ajax()) {
            return $this->getList();
        }
        return sysView('factoryorders.index');
    }

    public function getList($id = 0)
    {
        if (Input::get('search')) {
            $factoryOrders = $this->factoryOrders->getSearchedPaginated(\Input::all(), 10, Input::get('factoryOrderBy', 'created_at'), Input::get('factoryOrderType', 'DESC'));
        } else {
            $factoryOrders = $this->factoryOrders->getPaginated(10, Input::get('factoryOrderBy', 'created_at'), Input::get('factoryOrderType', 'DESC'));
        }
        return response()->json(array(
            'data' => sysView('factoryorders.partials.list', compact('factoryOrders'))->render(),
            'pagination' => sysView('includes.pagination', ['data' => $factoryOrders])->render(),
        ));
    }

    /*
     * Show the form for creating a new resource.
     * GET /factoryOrders/create
     *
     * @return Response
     */

    public function create(ProductRepository $repository)
    {
        if (Input::get('search')) {
            $products = $repository->getSearchedPaginated(Input::all(), 100, Input::get('factoryOrderBy', 'name'), Input::get('factoryOrderType', 'ASC'));
        } else {
            $products = $repository->getPaginated(100, Input::get('factoryOrderBy', 'name'), Input::get('factoryOrderType', 'ASC'));

        }
        return sysView('factoryorders.create', compact('products'));
    }

    public function putShip($id)
    {
        $this->factoryOrders->shipCart(decryptIt($id), Input::all());
        return redirect()->back()->with(['success' => 'Shipped']);
    }

    /*
     * Store a newly created resource in storage.
     * POST /factoryOrders
     *
     * @return Response
     */
    public function store()
    {
        if (!Input::get('variants')) {
            throw new ApplicationException("Please check the item first");
        }
        $this->factoryOrders->validator->with(Input::all())->setMessages([
            'variants.*.*.distinct' => 'You have selected same variant twice for a product. Please remove duplicate variant.'
        ])->isValid();
        if ($this->factoryOrders->placeOrder(Input::all())) {
            return response()->json(array(
                'notification' => ReturnNotification(array('success' => 'Added To Cart')),
                'redirect' => Input::get('redirect_url', route('webpanel.factoryorders.index'))
            ));
        }
        throw new ApplicationException('Cannot be added at the moment');
    }

    public function getPlace()
    {
        if (!session(\App\Modules\FactoryOrders\FactoryOrder::SESSION_KEY)) {
            throw new ApplicationException("No FactoryOrder Placed");
        }
        $factoryOrder = FactoryOrder::Current();
        if ($factoryOrder->place()) {
            return redirect()->route('webpanel.factoryorders.show', encryptIt($factoryOrder->id))->with(['success' => 'FactoryOrder Placed']);
        }
        throw new ApplicationException("Cannot place you factoryOrder at the moment. Please try again later");
    }

    public function putPlaceForDealer(){
        if (!session(\App\Modules\FactoryOrders\FactoryOrder::SESSION_KEY)) {
            throw new ApplicationException("No FactoryOrder Placed");
        }
        $factoryOrder = FactoryOrder::Current();
        if ($factoryOrder->place(Input::get('user_id'))) {
            return redirect()->route('webpanel.factoryorders.show', encryptIt($factoryOrder->id))->with(['success' => 'FactoryOrder Placed']);
        }
        throw new ApplicationException("Cannot place you factoryOrder at the moment. Please try again later");
    }

    public function getFinished($id)
    {
        $id = decrypt($id);
        $factoryOrder = $this->factoryOrders->getById($id);
        if (is_null($factoryOrder)) {
            throw new ResourceNotFoundException('FactoryOrder not Found');
        }
        return sysView('factoryorders.finished', compact('factoryOrder'));
    }

    /**
     * Display the specified resource.
     * GET /factoryOrders/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $id = decrypt($id);
        $factoryOrder = $this->factoryOrders->getById($id);
        if (is_null($factoryOrder)) {
            throw new ResourceNotFoundException('FactoryOrder not Found');
        }
        return sysView('factoryorders.show', compact('factoryOrder'));

    }

    /**
     * Show the form for editing the specified resource.
     * GET /factoryOrders/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $factoryOrder = $this->factoryOrders->getById($id);
        if (is_null($factoryOrder)) {
            throw new ResourceNotFoundException('FactoryOrder not Found');
        }
        return sysView('factoryorders.partials.edit-modal', compact('factoryOrder'));
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /factoryOrders/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    /*
     * Delete the factoryOrders along with their related data like permissions.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function getDelete($id)
    {
        $id = decrypt($id);
        if ($this->factoryOrders->deleteFactoryOrder($id)) {
            echo 1;
        } else {
            throw new Exception('Cannot delete FactoryOrder at the moment');
        }
    }

    public function getDeleteCartItem($id)
    {
        $id = decrypt($id);
        if ($this->factoryOrders->deleteCartItem($id)) {
            return redirect(sysUrl('factoryOrders/cart/xl'));
        } else {
            throw new Exception('Cannot delete FactoryOrder at the moment');
        }
    }


    public function getApprove($id)
    {
        $id = decrypt($id);
        $factoryOrder = $this->factoryOrders->getById($id);
        if (is_null($factoryOrder)) {
            throw new ResourceNotFoundException('FactoryOrder not Found');
        }
        $factoryOrder->approve();
        return redirect()->back()->with(['success' => 'Approved. Waiting for payment.']);
    }

    public function getPay($id)
    {
        $id = decrypt($id);
        $factoryOrder = $this->factoryOrders->getById($id);
        if (is_null($factoryOrder)) {
            throw new ResourceNotFoundException('FactoryOrder not Found');
        }
        $factoryOrder->pay();
        return redirect()->back()->with(['success' => 'Paid']);
    }

    public function putDecline($id)
    {
        $id = decrypt($id);
        $factoryOrder = $this->factoryOrders->getById($id);
        if (is_null($factoryOrder)) {
            throw new ResourceNotFoundException('FactoryOrder Not Found');
        }
        $factoryOrder->decline(Input::get('remarks'));
        return redirect()->back()->with(['success' => 'FactoryOrder Declined']);
    }


    public function getDownload(PdfExportService $exportService, $id){
        $id = decrypt($id);
        $factoryOrder = $this->factoryOrders->getById($id);
        if (is_null($factoryOrder)) {
            throw new ResourceNotFoundException('FactoryOrder Not Found');
        }
        return $exportService
            ->setName($factoryOrder->OID.'.pdf')
            ->load(view('pdf.factoryorders.details', compact('factoryOrder'))->render())
            ->stream();
    }

    public function getDownloadAll(PdfExportService $exportService){
        if (Input::get('search')) {
            $factoryOrders = $this->factoryOrders->getSearchedPaginated(\Input::all(), 1000000000, Input::get('factoryOrderBy', 'created_at'), Input::get('factoryOrderType', 'DESC'));
        } else {
            $factoryOrders = $this->factoryOrders->getPaginated(10000000000, Input::get('factoryOrderBy', 'created_at'), Input::get('factoryOrderType', 'DESC'));
        }

        return $exportService->setName('FactoryOrders-'.date("Y-m-d").".pdf")
            ->load(view('pdf.factoryorders.all', compact('factoryOrders')))
            ->download();
    }

}
