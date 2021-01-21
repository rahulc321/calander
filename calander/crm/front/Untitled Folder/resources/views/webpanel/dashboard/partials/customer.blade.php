<div class="page-header">
    <div class="page-title">
        <h3>Dashboard</h3>
    </div>
</div>

<ul class="info-blocks">
    <li class="bg-primary">
        <div class="top-info">
            <a href="#">Purchase Today</a>
            <small>{{ currency((float) auth()->user()->orders()->forToday()->paid()->sum('price')) }}</small>
        </div>
        <a href="javascript:void(0);"><i class="icon-coin"></i></a>
    </li>
    <li class="bg-success">
        <div class="top-info">
            <a href="#">Total Purchase</a>
            <small>{{ currency((float) auth()->user()->orders()->paid()->sum('price')) }}</small>
        </div>
        <a href="javascript:void(0);"><i class="icon-coin"></i></a>
    </li>
    <li class="bg-danger">
        <div class="top-info">
            <a href="#">Month To Date Purchase</a>
            <small>{{ currency((float) auth()->user()->orders()->paid()->whereRaw(DB::raw("MONTH(created_at) = MONTH(CURDATE())"))->sum('price')) }}</small>
        </div>
        <a href="javascript:void(0);"><i class="icon-stats2"></i></a>
    </li>
    <li class="bg-info">
        <div class="top-info">
            <a href="#">Orders To Fulfill</a>
            <small>{{ (int) auth()->user()->orders()->shipped()->count('id') }}</small>
        </div>
        <a href="javascript:void(0);"><i class="icon-cart-checkout"></i></a>
    </li>
</ul>
