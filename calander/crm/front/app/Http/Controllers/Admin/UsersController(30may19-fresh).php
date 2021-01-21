<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Helpers\Authority;
use App\Http\Controllers\Controller;
use App\Modules\Users\Budget;
use App\Modules\Users\Message;
use App\Modules\Users\UserRepository;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Input;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Services\Email\EmailService;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use View;

class UsersController extends Controller
{
    use ResetsPasswords;
    private $users;


    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }

    /**
     * Display a listing of the resource.
     * GET /userusers
     *
     * @return Response
     */
    public function index()
    {
        Authority::authorize('list', 'users');
        /*for ajax request*/
        if (\Request::ajax()) {
            return $this->getList();
        }
        return auth()->user()->isAdmin() ? view('webpanel.users.index') : sysView('users.index-for-dealers');
    }

    public function getList($id = 0)
    {
        $users = $this->users->getPaginated(Input::all(), 10, Input::get('orderBy', 'id'), Input::get('orderType', 'ASC'));
        /*echo 'hello world';*/

        return response()->json(array(
            'data' => view('webpanel.users.partials.list', compact('users'))->render(),
            'pagination' => sysView('includes.pagination', ['data' => $users])->render()
        ));
    }

    /**
     * Show the form for creating a new resource.
     * GET /users/create
     *
     * @return Response
     */
    public function create()
    {
        Authority::authorize('add', 'users');
        return sysView('users.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /users
     *
     * @return Response
     */
    public function store()
    {
        Authority::authorize('add', 'users');
        //provide the validation data
        $this->users->validator->with(Input::all())->isValid();

        /*$this->users->checkDuplicateUsers(Input::get('email'));*/

        $user = $this->users->createUser(Input::all());
        //finally add the user
        /*var_dump($u);
        die();*/

        return response()->json(array(
            'notification' => ReturnNotification(array('success' => 'Created Successfully')),
            'redirect' => sysRoute('users.index')
        ));


    }

    /**
     * Display the specified resource.
     * GET /users/{id}
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
     * GET /users/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        Authority::authorize('edit', 'users');
        $id = decrypt($id);
        $user = $this->users->getById($id);
        if (is_null($user)) {
            throw new ResourceNotFoundException('User not Found');
        }
        return sysView('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /users/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        Authority::authorize('edit', 'users');
        //set up validation data
        $id = decryptIt($id);
        $this->users->validator->with(Input::all())->setDefault('edit-with-pass');
        if (Input::get('password') == '' || !Input::get('password')) {
            $this->users->validator->setDefault('edit');
        }
        //check if the validation is OK
        $this->users->validator->isValid();
        if ($this->users->updateUser($id, Input::all())) {
            return response()->json(array(
                'notification' => ReturnNotification(array('success' => 'User Info Saved Successfully')),
                'redirect' => route('webpanel.users.index')
            ));

        }

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /users/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Get the profile View
     *
     * @return \Illuminate\View\View
     */
    public function getProfile()
    {
        $user = $this->users->getById(\Auth::user()->id);
        return sysView('users.profile', compact('user'));
    }

    public function postProfile()
    {
        //set up validation data
        $this->users->validator->with(Input::all());
        $this->users->validator->setDefault('profile');

        //check if the validation is OK
        $this->users->validator->isValid();

        $userData = Input::all();
        if (Input::hasFile('photo')) {
            /*$this->users->validator->setDefault('photo');
            if (!$this->users->validator->isValid()) {
                return redirect()->back()->with(array('errors' => $this->users->validator->getErrors()));
            }*/
            $userData['photo_id'] = $this->users->uploadMedia(Input::file('photo'), true)->id;
            $this->users->deleteOldMedia(Input::get('old_photo'), true);;
        }


        if ($this->users->updateUser(\Auth::user()->id, $userData)) {
            return back()->with(array('success' => 'User Info Saved Successfully'));
            //return Redirect::route('admin.users.edit',array('id'=>$id))->with('success','User Saved Successfully');
        } else {
            redirect()->back()->with(array('error', 'Sorry! cannot perform the requested action at the moement'));
        }
    }

    /**
     * Get the change password view
     * @return \Illuminate\View\View
     */
    public function getChangePassword()
    {
        return sysView('users.changepassword');
    }

    /**
     * Post from change password view
     * @return \Illuminate\View\View
     */

    public function postChangePassword()
    {
        $this->users->validator->with(Input::all())->setDefault('change_password')->isValid();

        if ($this->users->changePassword(Input::get('password'))) {
            return back()->with(array('success' => 'User Info Saved Successfully'));
        } else {
            back()->with(array('error', 'Sorry! cannot perform the requested action at the moement'));
        }
    }


    public function getResetPassword(Guard $auth, PasswordBroker $passwords, $id)
    {
        $user = $this->users->getById(decrypt($id));
        if (!$user) {
            throw new ApplicationException("Invalid User Data");
        }
        $password = str_random(6);
        if ($this->users->changePassword($password, $user)) {
            $emailService = new EmailService();
            $emailService->sendEmail('emails.users.password-reset', compact('user', 'password'), function ($email) use ($user) {
                $email
                    ->setSubject(\Config::get('strings.user.passwordReset'))
                    ->setTo($user->email);
            });
            return redirect()->route('webpanel.users.index')->with('success', 'Password Reset Successful');
        }
        throw new ApplicationException("Opps! Something went wrong. Please try again later");
    }


    public function getDefaultPermissions($type)
    {
        $userType = \App\Modules\Users\Types\UserType::find($type);
        return view('webpanel.users.partials.default-permissions', compact('userType'));
    }


    /*
     * Delete the users along with their related data like permissions.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function getDelete($id)
    {
        Authority::authorize('delete', 'users');
        if ($this->users->deleteUser(decryptIt($id))) {
            echo 1;
        } else {
            throw new Exception('Cannot delete User at the moment');
        }
    }


    public function getClientMap()
    {
        $jsData['users'] = $this->users->getClientsForMap();
        return sysView('users.map', compact('jsData'));
    }


    public function getMessageInactive($id)
    {
        $user = $this->users->requireById(decryptIt($id));
        return sysView('users.partials.message-modal', compact('user'));
    }

    public function postMessageInactive(EmailService $emailService, $id)
    {
        if (!Input::get('message')) {
            throw new ApplicationException("Invalid");
        }

        $user = $this->users->requireById(decryptIt($id));
        $user->messages()->save(new Message([
            'message' => Input::get('message')
        ]));

        if (Input::get('sendEmail')) {
            $emailService->setSubject('Message from Moretti')->setTo($user->email)
                ->sendEmail('emails.users.inactive-message', [
                    'msg' => Input::get('message'),
                    'user' => $user
                ]);
        }

        return redirect()->back()->with(['success' => 'Message Sent']);

    }

    public function getBudgetPlanning($id)
    {
        $user = $this->users->requireById(decryptIt($id));
        return sysView('users.budget-planning', compact('user'));
    }

    public function postBudgetPlanning($id)
    {
        $user = $this->users->requireById(decryptIt($id));

        $data = Input::all();
        foreach ($data['budget'] as $month => $budget) {
            $user->budgets()->save(new Budget([
                'month' => $month,
                'budget' => $budget
            ]));
        }

        return redirect()->back()->with(['success' => 'Budget Updated']);
    }


     // new chnanges 15 april 
    public function contact(Request $request){ 

       

        $data= $request->all();
        if(!empty($data)){
            $current_user_email = \Auth::user()->email;
            $admin_email = 'morten@morettimilano.com';;
            $name = \Auth::user()->full_name;
            $data1=
                [
                    "user_email" => $current_user_email ,
                    "name" => $name ,
                    "message" => $data['message']
                    
                ];
            $emailService = new EmailService();
            $emailService->sendEmail('emails.contact.contact', compact('data1', $data1), function ($email) use ($admin_email) {
            $email
            ->setSubject('Message from Contact Us')
            ->setTo($admin_email);
            });
            return view('webpanel.contact.create')->with('success_message','Your message has been sussessfully sent.');
            }
        //echo '<pre>';print_r($data['message']);die;
        //echo 'email'.Auth::user()->email;
        return view('webpanel.contact.create');
        //return view('emails.contact.contact');
    }
}