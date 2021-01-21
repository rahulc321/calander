<?php
/**
 * Created by PhpStorm.
 * User: monkeyDluffy
 * Date: 2/3/2016
 * Time: 7:54 PM
 */

namespace App\Modules\Users\Traits;


use App\Modules\CreditNotes\CreditNote;
use App\Modules\Currencies\Currency;
use App\Modules\Forums\Discussion;
use App\Modules\Forums\Thread;
use App\Modules\Leads\Lead;
use App\Modules\Orders\Order;
use App\Modules\Users\Budget;
use App\Modules\Users\Message;
use App\User;

trait UserRelations
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userType()
    {
        return $this->belongsTo('App\Modules\Users\Types\UserType', 'user_type_id');
    }

    public function forumComments()
    {
        return $this->hasMany(Discussion::class, 'created_by');
    }

    public function threads()
    {
        return $this->hasMany(Thread::class, 'created_by');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function photo()
    {
        return $this->hasOne('Optimait\Laravel\Models\Attachment', 'id', 'photo_id');
    }

    public function documents()
    {
        return $this->morphMany('Optimait\Laravel\Models\Attachment', 'attachable')
            ->where('type', 'LIKE', User::ATTACHMENT_DOCUMENT);
    }

    public function assignedLeads()
    {
        return $this->hasMany(Lead::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'created_by');
    }

    public function myCustomers()
    {
        return $this->hasMany(User::class, 'created_by')->customers();
    }

    public function mySales()
    {
        return $this->hasMany(User::class, 'created_by')->sales();
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function budgets()
    {
        return $this->hasMany(Budget::class, 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    public function creditNotes()
    {
        return $this->hasMany(CreditNote::class, 'user_id');
    }

    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}