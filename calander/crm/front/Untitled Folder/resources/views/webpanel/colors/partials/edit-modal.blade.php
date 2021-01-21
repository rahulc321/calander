<div class="modal-dialog">
    <div class="modal-content">
        <form action="{{ route('webpanel.colors.update', $color->id) }}" method="post" class="ajaxForm"
              data-notification-area="#colorNotification">
            <div id="colorNotification"></div>
            <input type="hidden" name="_method" value="put">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Color</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="form-group required">
                        <label class="" for="name">Name*</label>
                        <div class="">
                            <input type="text" class="form-control" name="name" required value="{{ $color->name }}">
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="" for="hex_code">Color Code*</label>
                        <div class="">
                            <input type="text" class="form-control" name="hex_code" required value="{{ $color->hex_code }}">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>