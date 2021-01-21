<div class="page-header">
    <div class="page-title">
        <h3>Dashboard</h3>
    </div>
</div>

<ul class="info-blocks">
    <li class="bg-primary">
        <div class="top-info">
            <a href="#">Sales Today</a>
            <small><?php echo e(currency((float) \App\Modules\Orders\Order::forToday()->paid()->forMe()->sum('price'))); ?></small>
        </div>
        <a href="javascript:void(0);"><i class="icon-coin"></i></a>
    </li>
    <li class="bg-success">
        <div class="top-info">
            <a href="#">Customer Today</a>
            <small><?php echo e((int) \App\User::customers()->onlyMine()->forToday()->count('id')); ?></small>
        </div>
        <a href="javascript:void(0);"><i class="icon-users"></i></a>
    </li>
    <li class="bg-danger">
        <div class="top-info">
            <a href="#">Month To Date Sales</a>
            <small><?php echo e(currency((float) \App\Modules\Orders\Order::paid()->whereRaw(DB::raw("MONTH(created_at) = MONTH(CURDATE())"))->forMe()->sum('price'))); ?></small>
        </div>
        <a href="javascript:void(0);"><i class="icon-stats2"></i></a>
    </li>
    <li class="bg-info">
        <div class="top-info">
            <a href="#">Orders To Fulfill</a>
            <small><?php echo e((int) \App\Modules\Orders\Order::forToday()->ordered()->forMe()->count('id')); ?></small>
        </div>
        <a href="javascript:void(0);"><i class="icon-cart-checkout"></i></a>
    </li>
</ul>