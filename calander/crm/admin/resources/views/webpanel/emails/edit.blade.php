@extends('webpanel.layouts.base')
@section('title')
Edit Email
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Update Email Template</h3>
        </div>
    </div>

        <div class="row">
            <div class="col-lg-12">
                @include('webpanel.includes.notifications')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title">Update</h6>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal ajaxForm" method="post"
                              action="<?php echo sysUrl('emails/update/' . encryptIt($email->id)); ?>"
                              role="form" data-result-container="#notificationArea">

                            <input type="hidden" name="_method" value="put">

                            <div class="form-group">
                                <label class="col-md-2" for="subject">Subject:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="subject" name="subject" value="{{ $email->subject }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2" for="message">Email Template:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="message" name="message" rows="10">{{ $email->message }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2">&nbsp;</label>
                                <div class="col-sm-6">
                                    <input type="submit" value="Update" class="btn btn-warning btn-sm submit-btn">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
        <!-- <textarea name="editor1"></textarea> -->
@stop

@section('scripts')
        <script>
            CKEDITOR.replace( 'message' );
        </script>

    <script>
        (function ($, window, document, undefined) {
            $(function () {


            });

        })(jQuery, window, document);
    </script>

@stop

