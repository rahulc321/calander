<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Authority;
use App\Http\Controllers\Controller;
use App\Modules\FactoryOrders\FactoryOrder;
use App\Modules\Orders\Item;
use App\Modules\Orders\Order;
use App\Modules\Products\ProductRepository;
use App\Modules\Products\Variant;
use Exception;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Input;
use Optimait\Laravel\Services\PdfExport\PdfExportService;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ProductsController extends Controller
{
    use ResetsPasswords;
    private $products;


    public function __construct(ProductRepository $productRepository)
    {
        $this->middleware(['auth.onlyAdmin'], ['except' => ['getItemForOrder', 'getVariantsAjax', 'getOrders']]);
        $this->products = $productRepository;
    }

    /**
     * Display a listing of the resource.
     * GET /productproducts
     *
     * @return Response
     */
    public function index()
    {
        Authority::authorize('list', 'products');
        /*for ajax request*/
        if (\Request::ajax()) {
            return $this->getList();
        }
        return view('webpanel.products.index');
    }

    public function getList($id = 0)
    {
        $products = $this->products->getSearchedPaginated(Input::all(), 10, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));
        /*echo 'hello world';*/

        return response()->json(array(
            'data' => view('webpanel.products.partials.list', compact('products'))->render(),
            'pagination' => sysView('includes.pagination', ['data' => $products])->render()
        ));
    }

    /**
     * Show the form for creating a new resource.
     * GET /products/create
     *
     * @return Response
     */
    public function create()
    {
        Authority::authorize('add', 'products');
        return sysView('products.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /products
     *
     * @return Response
     */
    public function store()
    {
        Authority::authorize('add', 'products');
        //provide the validation data
        $this->products->validator->with(Input::all())->isValid();

        /*$this->products->checkDuplicateProducts(Input::get('email'));*/
        /*pd(Input::file('photo'));*/

        $product = $this->products->createProduct(Input::all());
        $photos = Input::file('photo');
        if (@$photos[0] != '') {
            foreach ($photos as $photo) {
                $product->photos()->save($this->products->uploadMedia($photo, true));
            }
            /*$data['photo_id'] = $this->products->uploadMedia(Input::file('photo'), true)->id;*/
        }
        //finally add the product
        /*var_dump($u);
        die();*/

        return response()->json(array(
            'notification' => ReturnNotification(array('success' => 'Created Successfully')),
            'redirect' => sysRoute('products.index')
        ));


    }

    /**
     * Display the specified resource.
     * GET /products/{id}
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
     * GET /products/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        Authority::authorize('edit', 'products');
        $id = decrypt($id);
        $product = $this->products->getById($id);
        if (is_null($product)) {
            throw new ResourceNotFoundException('Product not Found');
        }
        return sysView('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /products/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {

        Authority::authorize('edit', 'products');
        //set up validation data
        /*$id = decryptIt($id);*/
        $this->products->validator->with(Input::all())->setMessages([
            'colors.*.distinct' => 'There is a duplicate variant. Please remove it.'
        ])->isValid();
        $all = Input::all();
         
        unset($all['stock_qty']);
        if ($product = $this->products->updateProduct($id,$all, Input::all())
        ) {
            $photos = Input::file('photo');
            if (@$photos[0] != '') {
                foreach ($photos as $photo) {
                    $product->photos()->save($this->products->uploadMedia($photo, true));
                }
                /*$data['photo_id'] = $this->products->uploadMedia(Input::file('photo'), true)->id;*/
            }
            return response()->json(array(
                'notification' => ReturnNotification(array('success' => 'Product Info Saved Successfully')),
                'redirect' => route('webpanel.products.index')
            ));

        }

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /products/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    /*
     * Delete the products along with their related data like permissions.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function getDelete($id)
    {
        Authority::authorize('delete', 'products');
        if ($this->products->deleteProduct(decryptIt($id))) {
            echo 1;
        } else {
            throw new Exception('Cannot delete Product at the moment');
        }
    }


    public function getDeleteVariant($id){
        Authority::authorize('delete', 'products');
        if ($this->products->deleteVariant(decryptIt($id))) {
            echo 1;
        } else {
            throw new Exception('Cannot delete Product at the moment');
        }
    }

    public function getItemForOrder($id)
    {
        $id = decrypt($id);
        $product = $this->products->getById($id);
        if (is_null($product)) {
            throw new ResourceNotFoundException('Product not Found');
        }
        return sysView('products.for-order', compact('product'));
    }

    public function postQuantity($id)
    {
        $id = decrypt($id);
        $product = $this->products->getById($id);
        if (is_null($product)) {
            throw new ResourceNotFoundException('Product not Found');
        }
        $product->qty = Input::get('qty');
        $product->save();
        return 1;
    }

    public function getDownload(PdfExportService $exportService)
    {
        $products = $this->products->getPaginated(100000000, Input::get('orderBy', 'id'), Input::get('orderType', 'ASC'), function ($q) {
            $searchData = Input::all();
            if (@$searchData['search']) {
                if (@$searchData['keyword']) {
                    $q->where(function ($q) use ($searchData) {
                        $q
                            ->orWhere('name', 'LIKE', '%' . $searchData['keyword'] . '%')
                            ->orWhere('sku', 'LIKE', '%' . $searchData['keyword'] . '%');
                    });
                }

                if (@$searchData['collection_id']) {
                    $q->where('collection_id', '=', $searchData['collection_id']);
                }
            }
        });

        return $exportService->setName('Products-' . date("Y-m-d") . ".pdf")
            ->load(view('pdf.products.all', compact('products')))
            ->download();

    }

    public function getStocks()
    {
        $products = $this->products->getPaginated(10000, Input::get('factoryOrderBy', 'name'), Input::get('factoryOrderType', 'ASC'));

        return sysView('products.stocks', compact('products'));
    }

    public function getDownloadStocks()
    {
        $products = $this->products->getPaginated(10000, Input::get('factoryOrderBy', 'name'), Input::get('factoryOrderType', 'ASC'));

        $pdfService = new PdfExportService();
        return $pdfService->setName("Stocks-" . date("Y-m-d") . ".pdf")
            ->load(view('pdf.products.stocks', compact('products')))
            ->download();
    }


    public function getOrders()
    {
        $products = $this->products->getTotalOrdered(Input::all(), 10);
        return sysView('products.orders', compact('products'));
    }


    public function getClear()
    {
        Order::where('id', '>', 0)->delete();
        FactoryOrder::where('id', '>', 0)->delete();
        Item::where('id', '>', 0)->delete();
        \App\Modules\FactoryOrders\Item::where('id', '>', 0)->delete();
        Variant::where('id', '>', 0)->update([
            'qty' => 0
        ]);


        return redirect()->back()->with(['success' => 'Cleared']);
    }

    public function getVariantsAjax($id)
    {
        $product = $this->products->requireById($id);
        $str = '<option value="">Select</option>';
        foreach ($product->variants as $variant) {
            $str .= '<option value="' . $variant->id . '">' . @$variant->color->name . '</option>';
        }

        return $str;
    }
}