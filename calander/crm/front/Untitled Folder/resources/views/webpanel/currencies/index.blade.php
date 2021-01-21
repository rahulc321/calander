@extends('webpanel.layouts.base')
@section('title')
Currencies Settings
    @parent
@stop

@section('body')
    <div class="page-header">
        <div class="page-title"><h3>Currencies Settings</h3></div>
    </div>

    @include('webpanel.includes.notifications')

    <div class="row">
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-bordered ajaxTable deleteArena"
                       data-request-url="<?php echo route('webpanel.currencies.index');?>">
                    <thead>
                    <tr>
                        <th class="sortableHeading" data-orderBy="id">SN</th>
                        <th class="sortableHeading" data-orderBy="name">Currency Name</th>
                        <th class="sortableHeading" data-orderBy="symbol">Symbol</th>
                        <th class="sortableHeading" data-orderBy="conversion">Conversion</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div>
                <nav id="paginationWrapper"></nav>
            </div>
        </div>

        <div class="col-md-4">
            <form class="ajaxForm form-horizontal" method="post"
                  action="<?php echo URL::route('webpanel.currencies.store');?>" role="form">
                <div class="panel panel-default">
                    <div class="panel-heading ">
                        <h6 class="panel-title">Add Currency</h6>
                    </div>
                    <div class="panel-body">
                        <div class="form-group required">
                            <div class="col-md-12">
                                <label class="" for="name">Currency Name*</label>
                                <div>
                                    <input type="text" class="form-control" required name="name" value="{{ Input::old('name') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-5">
                                <label for="symbol">Symbol*:</label>
                                <input type="text" class="form-control" id="symbol" name="symbol" value="{{ Input::get('symbol') }}" required>
                            </div>
                            <div class="form-group">
                                <div class="col-md-5">
                                    <label for="conversion">Conversion Rate*:</label>
                                    <input type="text" class="form-control" id="conversion" name="conversion" value="{{ Input::get('conversion') }}" required>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-warning submit-btn" value="Add">
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('modals')

@stop