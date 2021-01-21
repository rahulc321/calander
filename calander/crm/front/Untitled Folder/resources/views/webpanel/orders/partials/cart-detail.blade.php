<form class="form-inline" method="post" action="">
    @include('webpanel.includes.notifications')
    <div class="panel panel-default">
        <div class="panel-body">
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
                            <label class="checkbox-inline checkbox-success">
                                <input type="checkbox" class="styled" name="ids[{{ $item->id }}]"
                                       value="{{ $item->id }}">
                            </label>
                        </td>
                        <td>
                            <img src="{{ $item->product->getThumbUrl() }}">
                        </td>
                        <td>{{ @$item->product->name }}</td>
                        <td>{{ @$item->variant->sku }}</td>
                        <td>{{ @$item->variant->color->name }}</td>

                        <td width="55">
                            <input class="form-control" name="qty[{{ $item->id }}]"
                                   value="{{ $item->qty }}" pattern="[0-9]+">
                        </td>
                        <td>
                            {{ currency($item->price) }}
                        </td>
                        <?php $total = $item->price * $item->qty; $grandTotal += $total; ?>
                        <td>{{ currency($total) }}</td>
                        <td>
                            <a title="Delete Item"
                               href="<?php echo sysUrl('orders/delete-cart-item/' . encrypt($item->id)); ?>"
                               class="delete"
                               data-id="<?php echo $item->id; ?>"
                               data-token="<?php echo urlencode(md5($item->id)); ?>"><i class="icon-remove4"></i></a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7" style="text-align: right;">Total</th>
                    <th>
                        {{ currency($grandTotal) }}
                    </th>
                    <th></th>
                </tr>
                
                <tr>
                    <th colspan="7" style="text-align: right;">Wallet Amount</th>
                    <th>
                       {{ currency($grandTotal) }}
                    </th>
                    <th></th>
                </tr>
                
                <tr>
                    <th colspan="7" style="text-align: right;">Grand Total</th>
                    <th>
                         {{ currency($grandTotal) }}
                    </th>
                    <th></th>
                </tr>

                <tr>
                    <td colspan="10">
                        <input type="submit" class="btn btn-warning btn-sm" name="save" value="Update">
                        @if(auth()->user()->isCustomer())
                            <a class="btn btn-warning btn-sm" href="{{ sysUrl('orders/place/xl') }}">Place Order</a>
                        @else
                            <a class="btn btn-warning btn-sm" data-toggle="modal" data-target=".placeForDealerModal"
                               href="#">Place Order For</a>
                        @endif
                        @if(auth()->user()->isAdmin())
                            <a class="btn btn-warning btn-sm" data-toggle="modal" data-target=".replaceModal"
                               href="#">Add To Previous Order</a>
                        @endif
                        <a href="{{ sysRoute('orders.create') }}" class="btn btn-success pull-right btn-sm">Continue
                            Shopping</a>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</form>
