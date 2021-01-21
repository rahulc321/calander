<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">
            Search
        </h6>


    </div>
    <div class="panel-body">
        <form class="" method="get" action="<?php echo URL::route('webpanel.orders.index'); ?>" role="form">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Customer</label>
                        <div>
                        <select class="select2 lazySelector" name="user_id" style="width:200px;"
                                data-selected="{{ Input::get('user_id') }}">
                            <option value="">All</option>
                            {!! OptionsView(\App\User::exceptMe()->forMe()->customers()->get(), 'id', function($item){
                                return $item->fullName();
                            }) !!}
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date From</label>
                        <input type="text" class="form-control dp" name="date_from"
                               value="{{ Input::get('date_from') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date To</label>
                        <input type="text" class="form-control dp" name="date_to" value="{{ Input::get('date_to') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control lazySelector" name="status"
                                data-selected="{{ Input::get('status') }}">
                            <option value="">All</option>
                            @foreach(\App\Modules\Orders\Order::GetStatusAsArray() as $k => $status)
                                <option value="{{ $k }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2" style="margin-left:20px;">
                    <div class="form-group">
                        <label>Order ID</label>
                        <input type="text" class="form-control" name="oid" value="{{ Input::get('oid') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding-top: 25px;">
                        <input type="submit" class="btn btn-warning btn-sm margin-top-10" name="search" value="Search">
                        <a class="btn btn-danger btn-sm margin-top-10" href="{{ sysRoute('orders.index')}}">Reset</a>
                        <a href="{{ sysUrl('orders/download-all/xl') }}?{{ http_build_query(Input::except('page')) }}"
                           class="btn btn-success btn-sm"><i class="icon-print2"></i> Print</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
