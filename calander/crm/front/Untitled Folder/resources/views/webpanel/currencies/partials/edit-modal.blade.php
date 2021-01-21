<div class="modal-dialog">
    <div class="modal-content">
        <form action="{{ route('webpanel.currencies.update', $currency->id) }}" method="post"
              class="ajaxForm form-horizontal"
              data-notification-area="#currencyNotification">
            <div id="currencyNotification"></div>
            <input type="hidden" name="_method" value="put">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Currency</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="form-group required">
                        <div class="col-md-8">
                            <label class="" for="name">Currency Name*</label>
                            <div>
                                <input type="text" class="form-control" name="name" required value="{{ $currency->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4">
                            <label for="symbol">Symbol*:</label>
                            <input type="text" class="form-control" id="symbol" name="symbol" value="{{ $currency->symbol }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="conversion">Conversion*:</label>
                            <input type="text" class="form-control" id="conversion" name="conversion" value="{{ $currency->conversion }}" required>
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