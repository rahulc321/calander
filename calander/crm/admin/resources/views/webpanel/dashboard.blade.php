@extends('webpanel.layouts.base')
@section('title')
Dashboard
@parent
@stop
@section('body')

    <div class="content">
            <div class="row">
                <div class="col-lg-12 text-center m-t-md">
                </div>
            </div>
            @include('webpanel.dashboard.partials.'.strtolower(str_slug(auth()->user()->userType->title)))
    </div>
@stop

@section('scripts')

    <script>
        (function ($, window, document, undefined) {
            $(function () {

            });
        })(jQuery, window, document);
    </script>

@stop