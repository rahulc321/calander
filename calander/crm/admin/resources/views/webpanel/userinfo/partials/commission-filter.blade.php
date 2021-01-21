<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Search Invoices</h6>
    </div>
    <div class="panel-body">
        <form method="get" action="" role="form">


            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Sales Person</label>
                        <div>
                            <select class="select2 lazySelector" name="sales_id" style="width: 200px;"
                                    data-selected="{{ Input::get('sales_id') }}">
                                <option value="">All</option>
                                {!! OptionsView(\App\User::exceptMe()->forMe()->sales()->get(), 'id', function($item){
                                    return $item->fullName();
                                }) !!}
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-md-2" style="padding-top: 20px;">
                    <input type="submit" class="btn btn-warning btn-sm margin-top-10" name="search" value="Search">
                    <a class="btn btn-danger btn-sm margin-top-10" href="{{ sysUrl('commissions') }}">Reset</a>
                </div>

            </div>

        </form>
    </div>
</div>
