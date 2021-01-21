<?php
namespace App\Modules\Withdraws;


use App\Modules\Collections\Collection;
use App\Modules\Logs;
use App\Modules\Users\Traits\BelongsToOrganization;
use App\User;
use Laravel\Cashier\Billable;
use Optimait\Laravel\Models\Attachment;
use Optimait\Laravel\Traits\CreatedUpdatedTrait;
use Optimait\Laravel\Traits\CreaterUpdaterTrait;

class Withdraw extends \Eloquent
{
    use CreatedUpdatedTrait, CreaterUpdaterTrait;
    protected $table = 'withdraws';
    protected $fillable = ['amount', 'status', 'remarks'];


    const STATUS_DECLINED = 3;
    const STATUS_APPROVED = 4;
    const STATUS_PENDING = 1;

    public static $statusLabel = [
        self::STATUS_PENDING => '<label class="label label-warning">PENDING</label>',
        self::STATUS_APPROVED => '<label class="label label-success">APPROVED</label>',
        self::STATUS_DECLINED => '<label class="label label-danger">DECLINED</label>',
    ];

    public static function GetStatusAsArray()
    {
        return [
            self::STATUS_PENDING => 'PENDING',
            self::STATUS_APPROVED => 'APPROVED',
            self::STATUS_DECLINED => 'DECLINED',
        ];
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isApproved()
    {
        return $this->status == Withdraw::STATUS_APPROVED;
    }

    public function isPending()
    {
        return $this->status == Withdraw::STATUS_PENDING;
    }

    public function scopeForMe($q)
    {
        if (auth()->user()->isAdmin()) {
            return $q;
        }

        return $q->where('created_by', '=', auth()->user()->id);
    }

    public function scopeApproved($q)
    {
        return $q->where('status', '=', Withdraw::STATUS_APPROVED);
    }

    public function scopeNotDeclined($q)
    {
        return $q->where('status', '!=', Withdraw::STATUS_DECLINED);
    }

    public function selfDestruct()
    {
        return $this->delete();
    }
}