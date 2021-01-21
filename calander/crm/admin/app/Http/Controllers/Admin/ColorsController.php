<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Products\ColorRepository;
use Exception;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use View;

class ColorsController extends Controller
{
    private $colors;


    public function __construct(ColorRepository $colorRepository)
    {
        /*$this->middleware('auth.notEmployee');*/
        $this->colors = $colorRepository;

    }

    /**
     * Display a listing of the resource.
     * GET /colorcolors
     *
     * @return Response
     */
    public function index()
    {

        /*for ajax request*/
        if (\Request::ajax()) {
            return $this->getList();
        }

        /*$colors = $this->colors->getAllPaginated(10);*/
        //echo 'hello world';
        return view('webpanel.colors.index');
    }

    public function getList($id = 0)
    {
        $colors = $this->colors->getPaginated(10, Input::get('orderBy', 'name'), Input::get('orderType', 'ASC'));
        /*echo 'hello world';*/

        return response()->json(array(
            'data' => view('webpanel.colors.partials.list', compact('colors'))->render(),
            'pagination' => sysView('includes.pagination', ['data' => $colors])->render()
        ));
    }

    /**
     * Show the form for creating a new resource.
     * GET /colors/create
     *
     * @return Response
     */
    public function create()
    {
        return View::make('webpanel.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /colors
     *
     * @return Response
     */
    public function store()
    {
        //provide the validation data
        $this->colors->validator->with(Input::all())->isValid();

        if ($this->colors->createColor(Input::all())) {
            return response()->json(array(
                'notification' => ReturnNotification(array('success' => 'Created Successfully')),
                'redirect' => route('webpanel.colors.index')
            ));
        }

        throw new ApplicationException('Cannot be added at the moment');


    }

    /**
     * Display the specified resource.
     * GET /colors/{id}
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
     * GET /colors/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {

        $color = $this->colors->getById($id);
        if (is_null($color)) {
            throw new ResourceNotFoundException('Color not Found');
        }
        return View::make('webpanel.colors.partials.edit-modal', compact('color'));

    }

    /**
     * Update the specified resource in storage.
     * PUT /colors/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {

        //set up validation data
        $this->colors->validator->with(Input::all())->isValid();

        /*check if this is already taken*/
        /*$this->colors->checkDuplicateColors(Input::get('name'), $id);*/


        if ($this->colors->updateColor($id, Input::all())) {
            return response()->json(array(
                'notification' => ReturnNotification(array('success' => 'Color Info Saved Successfully')),
                'redirect' => route('webpanel.colors.index')
            ));

        }

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /colors/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    

    /**
     * Delete the colors along with their related data like permissions.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function getDelete($id)
    {
        if ($this->colors->deleteColor($id)) {
            echo 1;
        } else {
            throw new Exception('Cannot delete Color at the moment');
        }
    }


}