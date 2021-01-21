<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Filter/Search</h6>
    </div>
    <div class="panel-body">
        <form class="" method="get" action="<?php echo URL::route('webpanel.withdraws.index'); ?>" role="form">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date From</label>
                        <input type="text" class="form-control dp" name="date_from" value="{{ Input::get('date_from') }}">
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
                            @foreach(\App\Modules\Withdraws\Withdraw::GetStatusAsArray() as $k => $status)
                                <option value="{{ $k }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if(auth()->user()->isAdmin())
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Sales</label>
                            <select class="form-control lazySelector" name="user_id"
                                    data-selected="{{ Input::get('user_id') }}">
                                <option value="">All</option>
                                @foreach(\App\User::onlyMine()->sales()->get() as $k => $user)
                                    <option value="{{ $user->id }}">{{ $user->fullName() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                <div class="col-md-2">
                    <div style="padding-top: 25px;">
                        <input type="submit" class="btn btn-warning btn-sm margin-top-10" name="search" value="Search">
                        <a class="btn btn-danger btn-sm margin-top-10" href="{{ sysRoute('withdraws.index')}}">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
