<?php
namespace App\Modules\Users;


use App\Modules\Subscriptions\Plan;
use App\Modules\Subscriptions\Status;
use App\Services\Payments\Contracts\Payload;
use App\Services\Payments\Gateways\AuthorizeDotNet;

class UserSubscription extends \Eloquent
{
    use SubscriptionTrait;
    protected $fillable = ['authorize_id', 'user_id', 'ref_id', 'plan_id', 'subscription_status_id',
        'subscription_interval', 'next_billing_date'];
    protected $table = 'users_subscription';


    /*
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function setAuthorizeId($authorizeId)
    {
        $this->authorize_id = $authorizeId;
        $this->save();
    }

    public function logs()
    {
        return $this->hasMany("App\Modules\Subscriptions\Log", 'subscription_id', 'authorize_id')->orderBy('id', 'DESC');
    }

    public function changeStatus($statusId)
    {
        $this->subscription_status_id = $statusId;
        $this->save();
    }


}