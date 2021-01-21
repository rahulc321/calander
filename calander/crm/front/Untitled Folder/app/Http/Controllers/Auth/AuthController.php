<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*$this->middleware($this->guestMiddleware(), ['except' => 'logout', 'getLogout']);*/
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }


    public function authenticated($request, User $user)
    {
        /*Check if user is active*/
        $user->last_login_at = date("Y-m-d H:i:s");
        $user->login_count++;
        $user->save();
        return redirect(sysUrl('dashboard'));
        /*$user->setOnline(User::ONLINE);*/
        /*if ($user->isAdmin() || $user->isEmployee() || $user->isCompany()) {
            return redirect(sysUrl('dashboard'));
        } else {
            return redirect('dashboard');
        }*/
        /*return redirect()->intended($this->redirectPath());*/
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    public function getLogout()
    {
        \Session::flush();
        return $this->logout();

        /*return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');*/
    }


}
