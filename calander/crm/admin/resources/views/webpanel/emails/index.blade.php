@extends('webpanel.layouts.base')
@section('title')
Edit Email
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Email Template</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
        @include('webpanel.includes.notifications')

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">Update Email Template</h6>
            </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" data-request-url="">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Subject</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($emails as $k => $email)
                            <tr>
                                <td>{{ $k + 1 }}</td>
                                <td>{{ $email->subject }}
                                </td>
                                <td>
                                    <a href="{{ sysUrl('emails/edit/'.encryptIt($email->id)) }}" title="Edit">
                                        <i class="icon-pencil3"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
            </div>
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