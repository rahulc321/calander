<div class="modal-dialog">
    <div class="modal-content">
        <form action="{{ sysUrl('orders/decline/'.encryptIt($order->id)) }}" method="post" class=""
              data-notification-area="#categoryNotification">
            <div id="categoryNotification"></div>
            <input type="hidden" name="_method" value="put">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="modal-title" id="myModalLabel">DECLINE ORDER </div>
            </div>
            <div class="modal-body">
                <strong>Order Number: {{ $order->OID }}</strong> <br/>
                <strong>Order Date: </strong> {{ $order->createdDate() }}<br>
                <strong>Total Price: </strong> {{ @currency($order->price) }}<br>
                <strong>Total Items: </strong> {{ $order->items->count() }}<br>
                <div class="panel-body">
                    <div class="form-group required">
                        <label class="" for="name">Reason:</label>
                        <div class="">
                            <textarea class="form-control" name="remarks" required></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Decline</button>
            </div>
        </form>
    </div>
</div>