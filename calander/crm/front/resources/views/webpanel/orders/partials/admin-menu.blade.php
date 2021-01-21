@if($order->isOrdered() && auth()->user()->isAdmin())
    <div class="row">
        <div class="col-md-4">
            <label>Due Date:</label>
            <input type="text" class="form-control dp" id="due_date" name="due_date" value="{{ Input::get('due_date') }}">
        </div>
        <div class="col-md-4">
            <label>Shipping Cost:</label>
            <input type="number" class="form-control" id="shipping_price" name="shipping_price"
                   value="{{ Input::get('shipping_price') }}">
        </div>

        <div class="col-md-1">
            <br/>
            <input type="submit" value="Ship Order" name="shipOrder" class="btn btn-primary submit-btn">
        </div>

    </div>
@endif
