@section('modals')
    <div class="modal fade messageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ sysUrl('users/message-inactive/xl') }}" class="form-horizontal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Send Message</h4>
                    </div>
                    <div class="modal-body with-padding">
                        <div class="form-group">
                            <input type="hidden" name="inactive_user_id">
                            <div class="col-md-12">
                                <label>Message:</label>
                                <div>
                                    <textarea class="form-control" name="message" style="height:150px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop


@section('scripts')
    @parent
    <script>
        $(function () {
            $(document).on('click', '.inactive-user', function (e) {
                $("[name=inactive_user_id]").val($(this).attr('data-id'));
                e.preventDefault();
                return false;
            })
        });
    </script>
@stop