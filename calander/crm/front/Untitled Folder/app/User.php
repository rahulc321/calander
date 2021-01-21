<?php

namespace App;

use App\Modules\Users\Traits\BelongsToOrganization;
use App\Modules\Users\Traits\BusinessOwnerTrait;
use App\Modules\Users\Traits\UserAuths;
use App\Modules\Users\Traits\UserHelper;
use App\Modules\Users\Traits\UserRelations;
use App\Modules\Users\Traits\UserScopes;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Optimait\Laravel\Traits\CreatedUpdatedTrait;
use Optimait\Laravel\Traits\CreaterUpdaterTrait;

class User extends Authenticatable implements Authorizable, CanResetPassword
{
    use \Illuminate\Auth\Passwords\CanResetPassword, UserScopes, UserAuths,
        UserRelations, UserHelper, CreaterUpdaterTrait, CreatedUpdatedTrait;

    const REGISTERED = 1;
    const CONFIRMED = 2;
    const ACTIVE = 10;

    const TYPE_COMPANY = 1;
    const TYPE_PERSONAL = 0;

    const ATTACHMENT_DOCUMENT = 'document';

    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_type_id', 'full_name', 'email', 'password', 'status', 'permissions', 'address', 'city', 'country', 'zipcode', 'vat_number',
        'photo_id', 'phone', 'is_company', 'commission', 'created_by', 'debitor_number', 'currency_id'
    ];

    /*
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function selfDestruct()
    {
        return $this->delete();
    }
}
