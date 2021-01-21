<?php

namespace App\Modules\Users;

use App\User;
use Auth;
use Hash;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Repos\EloquentRepository;
use Optimait\Laravel\Traits\UploaderTrait;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/*
 * Class UserRepository
 * @package App\Admin\User
 */

class UserRepository extends EloquentRepository
{
    use UploaderTrait;
    /*
     * @var UserValidator
     */
    public $validator;

    /*
     * @var
     */
    protected $insertedId;

    protected $password;


    /*
     * @param User $user
     * @param UserValidator $userValidator
     */
    public function __construct(User $user, UserValidator $userValidator)
    {
        $this->model = $user;
        $this->validator = $userValidator;
    }

    /*
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getNumberOfUser()
    {
        return $this->model
            ->exceptMe()
            ->forMe()
            ->count();
    }

    public function getPaginated($searchData = [], $items = 10, $orderBy = 'name', $orderType = 'DESC')
    {
        return $this->model
            ->exceptMe()
            ->forMe()
            ->with('userType')
            ->where(function ($q) use ($searchData) {
                if (@$searchData['name'] != '') {
                    $q->where('full_name', 'LIKE', '%' . urldecode($searchData['name'] . '%'));
                    /*$q->where(function($q) use($searchData){
                       $q
                           ->orWhere('first_name', 'LIKE', '%'.$searchData['name'].'%')
                           ->orWhere('last_name', 'LIKE', '%'.$searchData['name'].'%');
                    });*/
                }
                if (@$searchData['city'] != '') {
                    $q->where('city', 'LIKE', '%' . urldecode($searchData['city'] . '%'));
                    /*$q->where(function($q) use($searchData){
                       $q
                           ->orWhere('first_name', 'LIKE', '%'.$searchData['name'].'%')
                           ->orWhere('last_name', 'LIKE', '%'.$searchData['name'].'%');
                    });*/
                }

                if (@$searchData['user_type_id'] != '') {
                    $q->where('user_type_id', '=', $searchData['user_type_id']);
                }
                
            })
            ->orderBy($orderBy, $orderType)
            ->paginate($items);
    }

    public function getClientsPaginated($items = 10, $orderBy = 'name', $orderType = 'DESC')
    {
        return $this->model
            ->exceptMe()
            ->forMe()
            ->clients()
            ->with('userType', 'subscription.plan.detail', 'subscription.subscriptionStatus')
            ->orderBy($orderBy, $orderType)
            ->paginate($items);
    }

    public function searchClientsPaginated($searchData = array(), $items = 10, $orderBy = 'name', $orderType = 'DESC')
    {
        return $this->model
            ->exceptMe()
            ->where(function ($query) use ($searchData) {

                if (@$searchData['date_from'] != '') {
                    $query->whereRaw("DATE(created_at) >= '" . $searchData['date_from'] . "'");
                }

                if (@$searchData['date_to'] != '') {
                    $query->whereRaw("DATE(created_at) <= '" . $searchData['date_to'] . "'");
                }

                if (@$searchData['status'] != '') {
                    $query->whereHas('subscription', function ($q) use ($searchData) {
                        $q->where('subscription_status_id', '=', $searchData['status']);
                    });
                }


            })
            ->with('userType', 'subscription.plan.detail', 'subscription.subscriptionStatus')
            ->orderBy($orderBy, $orderType)
            ->paginate($items);
    }


    /*
     * @param $userData
     * @return bool
     */

    public function createUser($userData)
    {
        $userModel = parent::getNew($userData);
        $this->setPassword(str_random(6));
        $userModel->password = Hash::make($this->getPassword());
        $userModel->password_text = $this->getPassword();
        $userModel->setUserType($userData['user_type_id']);
        if($userModel->isCustomer()){
            $userModel->debitor_number = User::getNewDebitorValue();
        }

        if ($userModel->save()) {
            if(@$userData['created_by'] != ''){
                $userModel->created_by = $userData['created_by'];
                $userModel->save();
            }
            $this->insertedId = $userModel->id;

            event('user.saved', array($userModel, $userData, false, $this->getPassword()));

            return $userModel;
        }
        throw new ApplicationException('User cannot be added at this moment. Please try again later.');
    }


    /*
     * @param $userData
     * @return bool
     */

    public function updateUser($id, $userData, $returnModel = false)
    {
        $userModel = $this->getById($id);

        if (@$userData['password'] == '') {
            unset($userData['password']);
        } else {
            $userModel->password_text = $userData['password'];
            $userData['password'] = Hash::make($userData['password']);
        }

        $userModel->fill($userData);
        if ($userModel->save()) {
            event('user.saved', array($userModel, $userData));
            return $userModel;
        }

        throw new ApplicationException('User cannot be saved at this moment. Please try again later.');
    }


    /*
     * @param $password
     * @return mixed
     */
    public function changePassword($password, $userModel = null)
    {
        if (is_null($userModel)) {
            $userModel = Auth::getUser();
        }

        $userModel->password = Hash::make($password);
        $userModel->password_text = $password;
        //$userModel->password = 'Try';
        return $userModel->save();
    }

    /*
     * @return mixed
     */
    public function getInsertedId()
    {
        return $this->insertedId;
    }

    /*
     * @param $email the mail used to check the duplicate record in the db
     * @return void
     */

    public function checkDuplicateUsers($email)
    {
        //echo $email;
        if ($this->model->where('email', $email)->count() > 0) {
            throw new ApplicationException('The user is already registered.');
        }
        //print_r(\DB::getQueryLog());
    }

    /*
     * @param $id
     * @return int
     * @throws \Symfony\Component\Routing\Exception\ResourceNotFoundException
     */
    public function deleteUser($id)
    {
        //cet the user first
        $user = $this->getById($id);
        /*print_r($user);
        die();*/
        if (is_null($user)) {
            throw new ResourceNotFoundException('User not found.');
        }
        //$user->permissions()->delete();
        return $user->selfDestruct();
    }


    public function updateConfirmToken(User $user)
    {
        $user->confirm_token = str_random(16);
        return $user->save();
    }

    public function confirmUser($token)
    {
        $user = $this->model->where('confirm_token', 'LIKE', $token)->first();
        if ($user) {
            $user->status = User::ACTIVE;
            $user->save();
            return $user;
        }
        return false;
    }

    public function getSubscriptionByAuthorizeId($id)
    {

    }


    public function uploadSupportDocument($fileHandler)
    {
        $attachmentModel = $this->uploadMedia($fileHandler);
        $attachmentModel->type = User::ATTACHMENT_DOCUMENT;
        /*$attachmentModel->save();*/

        if (auth()->user()->documents()->save($attachmentModel)) {
            return $attachmentModel;
        }

        throw new ApplicationException("Something went wrong. Please try again later");

    }


    public function getIn($ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    public function getClientsForMap(){
        $users = $this->model->customers()->get();
        $data = [];
        foreach($users as $user){
            $data[] = [
                'id' => $user->id,
                'name' => $user->fullName(),
                'address' => $user->address,
                'isActive' => $user->hasOrderedInMonths()
            ];
        }

        return $data;
    }
    
    

    public function getUserDetails($id)
    {
        return $this->model
            ->where('id', $id)
            ->first();
    }
    
}