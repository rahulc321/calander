@extends('webpanel.layouts.base')
@section('title')
    Your Cart
    @parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Your Cart
                <small>ORDER ID: {{ $order->OID }}</small>
            </h3>
        </div>
        <div class="range">
            Order Date: {{ $order->createdDate() }}<br>
            <?php $totalItems = $order->items()->count('id'); ?>
            Cart: {{ $totalItems }} Items
        </div>
    </div>

    <div class="content">
        @if(!$order || $totalItems == 0)

            <div class="callout callout-danger" style="margin: 0;">
                <h5><i class="icon-cart-add"></i> No Items in a cart</h5>
                <p>No items in cart. Please add new items first. <a href="{{ sysRoute('orders.create') }}">Click
                        here</a> to add item.</p>
            </div>

        @else
            <div class="row">
                <div class="col-lg-12">
                    @include('webpanel.orders.partials.cart-detail')
                </div>
            </div>
        @endif
    </div>
@stop

@section('modals')
    <div class="modal fade replaceModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">

                <div class="modal-content">
                    <form method="post" action="{{ sysUrl('orders/replace/xl') }}"
                          data-notification-area="#replaceNotification">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add To Previous Order</h4>
                    </div>
                    <div class="modal-body">
                        <div class="panel-body">
                            <div class="row">
                                <label class="col-md-3" for="order_id">Select Order ID:</label>
                                <div class="col-md-6">
                                    <select class="form-control lazySelector" id="order_id" name="order_id"
                                            data-selected="{{ Input::get('order_id') }}">
                                        <option value="">Select</option>
                                        {!! OptionsView(\App\Modules\Orders\Order::ordered()->get(), 'id', 'OID') !!}
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                    </form>
                </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal placeForDealerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ sysUrl('orders/place-for-dealer/xl') }}" method="post"
                      data-notification-area="#placeForDealerNotification">
                    <div id="placeForDealerNotification"></div>
                    <input type="hidden" name="_method" value="put">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <div class="modal-title" id="myModalLabel">Select Client to Place Order</div>
                    </div>
                    <div class="modal-body">
                        <div class="panel-body">
                            <div class="form-group required">
                                <label for="name">Name of Client:</label>
                                <div>
                                    <select class="select2" name="user_id" required="required" style="width:100%;">
                                        <option value="">Select Client</option>
                                        @foreach(\App\User::customers()->onlyMine()->get() as $customer)
                                            <option value="{{ $customer->id }}"
                                                    @if($customer->shouldPayTax())
                                                    data-tax="1" data-taxpercent="{{ $customer->getTaxPercent() }}"
                                                    @else
                                                    data-tax="0"
                                                    @endif
                                            >{{ $customer->fullName() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <p class="hidden" id="tax-info">
                                <strong>Tax: </strong><span id="tax"></span>%
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-daanger btn-sm" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success btn-sm">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function () {
            $(document).on('change', '.placeForDealerModal [name=user_id]', function (e) {
                var selectedOption = $(this).find('option:selected');
                if (selectedOption.attr('data-tax') == '1') {
                    $("#tax-info").removeClass('hidden');
                    $("#tax").text(selectedOption.attr('data-taxpercent'))
                }
                else {
                    $("#tax-info").addClass('hidden');
                }
            })
        })
    </script>
@stop