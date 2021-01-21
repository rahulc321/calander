@extends('webpanel.layouts.base')
@section('title')
    List Users
    @parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Users Management</h3>
        </div>
    </div>
    @include('webpanel.includes.notifications')

    <form method="get" action="" class="form-horizontal">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Filter</h3></div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-md-3">
                        <label for="name">User Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ Input::get('name') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="user_type_id">User Type:</label>
                        <select class="form-control lazySelector" id="user_type_id" name="user_type_id"
                                data-selected="{{ Input::get('user_type_id') }}">
                            <option value="">Select</option>
                            <option value="{{ \App\Modules\Users\Types\UserType::ADMIN }}">Administrator</option>
                            <option value="{{ \App\Modules\Users\Types\UserType::SALES_PERSON }}">Sales Person</option>
                            <option value="{{ \App\Modules\Users\Types\UserType::CUSTOMER }}">Customer</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="name">City:</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ Input::get('city') }}">
                    </div>

                    <div class="col-md-2" style="padding-top:25px;">
                        <input type="submit" class="btn btn-primary btn-xs" name="filter" value="Filter">
                        <a class="btn btn-danger btn-xs" href="{{ sysRoute('users.index') }}">Reset</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Users</h6>
            <div class="panel-icons-group">
                <a href="{{ sysUrl('users/client-map/xl') }}" class="btn btn-primary btn-xs">Customer Geo</a>
                <a href="{{ route('webpanel.users.create') }}" class="btn btn-primary btn-xs" style="margin-left: 5px;">Add
                    User</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered ajaxTable deleteArena"
                   data-request-url="<?php echo route('webpanel.users.index'); ?>">
                <thead>
                <tr>
                    <th class="sortableHeading" data-orderBy="name" width="16%">Full Name</th>
                    <th>Login Info</th>
                    <th>City</th>
                    <th class="sortableHeading" data-orderBy="email">Email Address</th>
                    <th>Phone</th>
                    <th>User Type</th>
                    <th>Assigned To</th>
                    <th class="sortableHeading" data-orderBy="discount">Commission(%)</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <nav id="paginationWrapper"></nav>
@stop


@section('scripts')
    <script>
        $(function(){

        });
    </script>
@stop
