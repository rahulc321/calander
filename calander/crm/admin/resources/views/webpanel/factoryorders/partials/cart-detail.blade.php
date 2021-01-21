<form class="form-inline" method="post" action="">
    @include('webpanel.includes.notifications')
    <div class="hpanel">
        <div class="panel-body">
            <h4>
                ORDER ID: {{ $order->OID }}
            </h4>
            <strong>Order Date: </strong> {{ $order->createdDate() }}<br>

            <table class="table table-responsive deleteArena">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Color</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $items = $order->items()->with('product.photos')->get(); $grandTotal = 0;?>
                @foreach($items as $k => $item)
                    <tr class="deleteBox">
                        <td>
                            <label>
                                <input type="checkbox" name="ids[{{ $item->id }}]" value="{{ $item->id }}" class="i-checks">
                            </label>
                        </td>
                        <td>
                            <img src="{{ $item->product->getThumbUrl() }}">
                        </td>
                        <td>{{ @$item->product->name }}</td>
                        <td>{{ @$item->product->sku }}</td>
                        <td>{{ @$item->variant->color->name }}</td>

                        <td width="55">
                           <input type="number" class="form-control" name="qty[{{ $item->id }}]" value="{{ $item->qty }}">
                        </td>
                        <td>
                            {{ currency($item->price) }}
                        </td>
                        <?php $total = $item->price * $item->qty; $grandTotal += $total; ?>
                        <td>{{ currency($total) }}</td>
                        <td>
                            <a title="Delete Item"
                               href="<?php echo sysUrl('orders/delete-cart-item/' . encrypt($item->id)); ?>"
                               class="btn btn-xs btn-danger delete"
                               data-id="<?php echo $item->id; ?>"
                               data-token="<?php echo urlencode(md5($item->id)); ?>"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7" style="text-align: right;">Grand Total</th>
                    <th>
                        {{ currency($grandTotal) }}
                    </th>
                    <th></th>
                </tr>
                <tr>
                    <td colspan="10">
                        <input type="submit" class="btn btn-warning2 btn-sm" name="save" value="Update">
                        @if(auth()->user()->isCustomer())
                            <a class="btn btn-warning2 btn-sm" href="{{ sysUrl('orders/place/xl') }}">Place Order</a>
                        @else
                            <a class="btn btn-warning2 btn-sm" data-toggle="modal" data-target=".placeForDealerModal"
                               href="#">Place Order For</a>
                        @endif
                        <a href="{{ sysRoute('orders.create') }}" class="btn btn-warning2 pull-right btn-sm">Continue Shopping</a>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</form>
