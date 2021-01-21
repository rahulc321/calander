<?php

namespace App\Http\Controllers\API;

 

use App\User;
use App\Http\Controllers\Controller;


/**
 * Class UserController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends Controller
{
    /** @var  UserRepository */
    public $successStatus = 200;

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * save location api
     *
     * @return \Illuminate\Http\Response
     */
    public function signup(Request $request){

        return Response::json(array(), 200);
    }


    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        $input = $request->all();
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        echo 'sds';die;

        $input = $request->all();

        echo '<pre>';print_r($input);die;

        $validator = Validator::make($input, [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|phone:AUTO,IN|unique:users',
            'password' => 'required',
            'confirmPassword' => 'required|same:password',
        ]);

        if ($validator->fails())
        {
            $errors = $validator->errors()->messages();
            $error=array();
            foreach ($errors as $key => $value)
            {
                $error[]=$value[0];
            }
            return response()->json(['error'=> implode(", ",$error)], 401);
        }
    }


    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }


    public function validateEmail(Request $request)
    {
        if($request->get("email")!='')
        {
            if(Auth::guest() || $request->get("id")=='0')
            {
                $u = User::where("email","=",$request->get("email"))->count();
            }
            elseif($request->get("id"))
            {
                $u = User::where("email","=",$request->get("email"))->where("id","!=",$request->get("id"))->count();
            }
            else
            {
                $u = User::where("email","=",$request->get("email"))->where("id","!=",Auth::id())->count();
            }
            if(!$u)
            {
                return response()->json(['success' => $u], $this->successStatus);
            }
            else
            {
                return response()->json(['error' => 'Email already exist'], 401);
            }
        }
        else
        {
            return response()->json(['success' => 1], $this->successStatus);
        }
    }

    /**
     * Display a listing of the User.
     * GET|HEAD /users
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
    }



    /**
     * Store a newly created User in storage.
     * POST /users
     *
     * @param CreateUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserAPIRequest $request)
    {
        $input = $request->all();

        $users = User::create($input);

        return $this->sendResponse($users->toArray(), 'User saved successfully');
    }

    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var User $user */
        $user = User::findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     *
     * @param  int $id
     * @param UpdateUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var User $user */
        $user = User::findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user = User::update($input, $id);

        return $this->sendResponse($user->toArray(), 'User updated successfully');
    }

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = User::findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();

        return $this->sendResponse($id, 'User deleted successfully');
    }


}
