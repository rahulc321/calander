        <div class="page-header">
            <div class="page-title">
                <h3>Dashboard</h3>
            </div>
        </div>
        <form class="" method="get" action="" role="form">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date From</label>
                <input type="text" class="form-control dp" name="date_from" value="">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date To</label>
                        <input type="text" class="form-control dp" name="date_to" value="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div style="padding-top: 25px;">
                        <input type="submit" class="btn btn-warning btn-sm margin-top-10" name="search" value="Search">
                    </div>
                </div>
            </div>
        </form>
        <ul class="info-blocks">
             <li class="bg-primary">
                <div class="top-info">
                    <a href="javascript:void();">Total Sales</a>
                    <div class="statusText">{{ currency((float) \App\Modules\Orders\Order::forToday()->paid()->sum('price')) }}</div>
                </div>
                <a href="javascript:void(0);"><i class="icon-cart5"></i></a>
            </li>
            <li class="bg-primary">
                <div class="top-info">
                    <a href="javascript:void();">Sales Today</a>
                    <div class="statusText">{{ currency((float) \App\Modules\Orders\Order::forToday()->paid()->sum('price')) }}</div>
                </div>
                <a href="javascript:void(0);"><i class="icon-cart5"></i></a>
            </li>
            <li class="bg-success">
                <div class="top-info">
                    <a href="javascript:void();">Customer Today</a>
                    <div class="statusText">{{ (int) \App\User::customers()->onlyMine()->forToday()->count('id')}}</div>
                </div>
                <a href="javascript:void(0);"><i class="icon-people"></i></a>
            </li>
            
            <li class="bg-info">
                <div class="top-info">
                    <a href="javascript:void();">Orders To Fulfill</a>
                    <div class="statusText">{{ (int) \App\Modules\Orders\Order::forToday()->ordered()->count('id') }}</div>
                </div>
                <a href="javascript:void(0);"><i class="icon-cart-checkout"></i></a>
            </li>
        </ul>