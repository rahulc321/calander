<?php


namespace App\Helpers;


use Optimait\Laravel\Exceptions\NotAuthorizedException;

class Authority {
    public static $userPermission;

    public static function authorize($action, $resource, $isRedirect = true)
    {
        return true;
        /*if user is administrator then no need for all this fuss :D*/
        if (\Auth::user()->isSuperAdmin()) {
            return true;
        }

        /*if we have already fetched the permissions no need to fetch again*/
        if (empty(self::$userPermission)) {
            if (\Auth::user()) {
                self::$userPermission = @\Auth::user()->permissions;
            } else {
                return false;
            }
        }
        /*print_r(self::$userPermission);*/

        if (isset(self::$userPermission->$resource->$action)) {
            return true;
        }
        /*We reached till here means no permission*/
        if ($isRedirect) {
            throw new NotAuthorizedException('You do not have the permission');
        }
        return false;
    }
} 