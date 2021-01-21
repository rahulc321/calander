<?php
namespace App\Http\Controllers\Admin;

use App\Core\Helper;
use App\Core\Helpers\Notify;
use App\Exceptions\ApplicationException;
use App\Http\Controllers\Controller;
use App\Modules\Users\Types\UserTypeRepository;
use Exception;
use Input;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Translation\Exception\InvalidResourceException;
use View;

class UserTypesController extends Controller
{
    private $userTypes;


    public function __construct(UserTypeRepository $userTypeRepository)
    {
        $this->userTypes = $userTypeRepository;

    }

    /**
     * Display a listing of the resource.
     * GET /userTypeuserTypes
     *
     * @return Response
     */
    public function index()
    {
        /*for ajax request*/
        if (\Request::ajax()) {
            return $this->getList();
        }

        $userTypes = $this->userTypes->getAllPaginated(10);
        //echo 'hello world';
        return view('webpanel.userTypes.index', compact('userTypes'));
    }

    public function getList($id = 0)
    {
        $userTypes = $this->userTypes->getPaginated(10, Input::get('orderBy', 'id'), Input::get('orderType', 'ASC'));
        /*echo 'hello world';*/

        return response()->json(array(
            'data' => view('webpanel.userTypes.partials.list', compact('userTypes'))->render(),
            'pagination' => $userTypes->appends(Input::except('page'))->render()
        ));
    }

    /**
     * Show the form for creating a new resource.
     * GET /userTypes/create
     *
     * @return Response
     */
    public function create()
    {
        return View::make('webpanel.userTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /userTypes
     *
     * @return Response
     */
    public function store()
    {


        //provide the validation data
        $this->userTypes->validator->with(Input::all());
        //check the validation
        $this->userTypes->validator->isValid();

        /*$this->userTypes->checkDuplicateUserTypes(Input::get('email'));*/

        //finally add the userType
        if($this->userTypes->createUserType(Input::all())){
            return response()->json(array(
                'notification' => Notify::ReturnNotification(array('success' => 'Created Successfully')),
                'redirect' => Input::get('_no_redirect')?'':route('webpanel.userTypes.index')
            ));
        }
    }

    /**
     * Display the specified resource.
     * GET /userTypes/{id}
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
     * GET /userTypes/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $userType = $this->userTypes->getById($id);
            if (is_null($userType)) {
                throw new ResourceNotFoundException('UserType not Found');
            }
            return View::make('webpanel.userTypes.edit', compact('userType'));
        } catch (ApplicationException $e) {
            return back()->with('info', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * PUT /userTypes/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {

        //set up validation data
        $this->userTypes->validator->with(Input::all());

        //check if the validation is OK
        $this->userTypes->validator->isValid();


        if ($this->userTypes->updateUserType($id, Input::all())) {
            return response()->json(array(
                'notification' => Notify::ReturnNotification(array('success' => 'UserType Info Saved Successfully')),
                'redirect' => route('webpanel.userTypes.index')
            ));

        }

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /userTypes/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }




    /**
     * Delete the userTypes along with their related data like permissions.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function getDelete($id)
    {
        /*print_r(Input::all());
        die();*/
        if(!Input::get('_delete_token') || Input::get('_delete_token') != urlencode(md5($id))){
            throw new InvalidResourceException('Invalid Request');
        }
        if ($this->userTypes->deleteUserType($id)) {
            echo 1;
        } else {
            throw new Exception('Cannot delete UserType at the moment');
        }
    }


}