<?php

namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;
use DB;
use Validator;
use Hash;
use App\User;

class UserApiController extends Controller
{
    /** @var  UserRepository */
    public $successStatus = 200;

    public function __construct()
    {
         
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

        dd();
        $userdata = array(
            'email' => $input['email'],
            'password' => $input['password']

        );
            if (Auth::attempt($userdata, (isset($data['remember']) ? true : false))) {

                $user = Auth::user();
                //$success['resetpassword'] =  true;
                $success['token'] =  $user->createToken('MyApp')->accessToken;
                return response()->json(['success' => $success], $this->successStatus);


            }else{
                
                return response()->json(['error'=> 'Invalid Usernanme or Password.'], 401);
            }

         
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
         

        $input = $request->all();

        

        $validator = Validator::make($input, [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required',
            
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

        $user = new User();
        $user->name= $input['firstName'].' '.$input['lastName'];
        $user->email= $input['email'];
        $user->phone= $input['phone'];
        $user->password= bcrypt($input['password']);

        $user->save();
        return response()->json(['success' => 'Success']);

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
