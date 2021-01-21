@extends('webpanel.layouts.base')
@section('title')
Not Authorized
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Unauthorized Access </h3>
        </div>
    </div>

    <div class="callout callout-danger fade in">
        <h5>Unauthorized Access/Permission Denied</h5>
        <p> Sorry! You do not have the sufficient permission to access the requested feature. Please contact
            your administrator regarding this.</p>
    </div>

@stop