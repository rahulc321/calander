@extends('webpanel.layouts.base')
@section('title')
List Colors
@parent
@stop

@section('body')
    <div class="page-header">
        <div class="page-title"><h3>Manage Color</h3></div>
    </div>

    @include('webpanel.includes.notifications')

    <div class="row">
        <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-bordered ajaxTable deleteArena"
                           data-request-url="<?php echo route('webpanel.colors.index');?>">
                        <thead>
                        <tr>
                            <th class="sortableHeading" data-orderBy="id">SN</th>
                            <th>Color</th>
                            <th class="sortableHeading" data-orderBy="name">Color Name</th>
                            <th class="sortableHeading" data-orderBy="hex_code">Code</th>
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
            <form class="ajaxForm" method="post" action="<?php echo URL::route('webpanel.colors.store');?>" role="form">

                <div class="panel panel-default">
                    <div class="panel-heading ">
                        <h6 class="panel-title">Add Color</h6>
                    </div>
                    <div class="panel-body">
                        <div class="form-group required">
                            <label class="" for="name">Name*</label>
                            <div class="">
                                <input type="text" class="form-control" required name="name" value="{{ Input::old('name') }}">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="" for="hex_code">Hex Code*</label>
                            <div class="">
                                <input type="text" class="form-control" required name="hex_code" value="{{ Input::old('hex_code') }}">
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