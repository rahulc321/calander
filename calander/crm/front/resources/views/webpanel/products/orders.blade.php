@extends('webpanel.layouts.base')
@section('title')
    Order and Stock Status
    @parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Order and Stock Status
            </h3>
        </div>
    </div>

    <div style="padding-top: 5px;">
        @include('webpanel.includes.notifications')
    </div>
    <form method="get" action="" class="form-horizontal">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">
                    Search
                </h6>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label col-md-2" for="keyword">Search Products:</label>
                    <div class="col-md-5">

                        <select class="lazySelector select2" name="keyword" style="width:100%;"
                                data-selected="{{ Input::get('keyword') }}">
                            <option value="">All</option>
                            {!! OptionsView(App\Modules\Products\Product::all(), 'name', 'name') !!}
                        </select>

                    </div>
                    <div class="col-md-4">
                        <input type="submit" name="filter" value="Filter" class="btn btn-primary btn-xs">
                        <a class="btn btn-danger btn-xs" href="{{ sysUrl('products-orders') }}">Reset</a>
                    </div>
                </div>

            </div>
        </div>

    </form>
    <?php $sum=0;
            $salePrice= 0;
     ?>
    @foreach($totalprice as $price)
    @foreach($price->variants as $variantPrice)
    <?php
    $itemQty=$variantPrice->qty;
    $productPrice= $price->price;
    $actPrice= $itemQty*$productPrice;

    $selP= $price->buying_price;
    $actSalePrice= $itemQty*$selP;

    $sum+=$actPrice;
    $salePrice+=$actSalePrice;





    ?>
     

    @endforeach
    @endforeach
    <style>
        .pqty {
            background-color: #546672;
            width: 113px;
            border-radius: 13px;
            padding: 10px;
            color: white;
        }
        .pprice {
            background-color: #546672;
            width: 236px;
            border-radius: 13px;
            padding: 10px;
            color: white;
        }
        .sel-price{
            background-color: #da6560;
            width: 236px;
            border-radius: 13px;
            padding: 10px;
            color: white;
        }
         
    </style>
    <div class="row">
        @if(auth()->user()->isAdmin())
            <div >
                <b class="pqty">Product Qty :<span class="aqty">{{count($totalprice)}}</span></b>
                <b class="pprice">Total Product Price : <span class="price1">{{currency($sum)}}</span></b>

                <b class="sel-price">Are Selling Price : <span class="price1">{{currency($salePrice)}}</span></b>
            </div>
            <br>
        @endif
        <div class="col-lg-12">
            
            <div class="table-responsive table-bordered">
                <table class="table deleteArena">
                    <thead>
                    <tr>
                        <th class="sortableHeading" data-orderBy="name">Name</th>
                        <th>Color</th>
                        <th>Stock Available</th>
                        @if(auth()->user()->isAdmin())
                            <th>Ordered Qty</th>
                            <th>Required QTY</th>
                            <th>Active Ordered Qty</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)

                        <?php $totalStock = 0; 
                        // echo '>>'.count($product);
                        ?>
                        <tr>
                            <td colspan="6"><strong>{{ $product->name }}</strong>
                                @if(auth()->user()->isAdmin())
                                    <br>Buying Price:{{ currency($product->price) }}<br>
                                
                                    Are Selling Price: {{$product->buying_price}} 
                                    <br>
                                
                                @endif


                                <img src="{{ asset($product->getThumbUrl()) }}">
                            </td>
                        </tr>
                        @foreach($product->variants as $variant)
                            <tr>
                                <td></td>
                                <td>{{ @$variant->color->name }}
                                    <div style="background: {{ @$variant->color->hex_code }}; width:20px; height:20px;"></div>
                                </td>
                                <td>
                                 @if(auth()->user()->isAdmin())
                                 @if($variant->qty < 0)
                                 {{ '0' }}
                                 @else
                                 {{ $variant->qty }}
                                @endif
                                @else
                                {{ $variant->qty}}
                                @endif
                                
                                </td>
                                <?php $totalStock += $variant->qty; ?>
                                @if(auth()->user()->isAdmin())
                                    <td>{{ $variant->getTotalOrdered() }}</td>

                                    <!-- <td>@if($variant->getTotalOrdered() !=0)<span
                                                class="label label-success">
                                        
                                         @if($variant->qty > $variant->getTotalOrdered())
                                        {{ '0' }} @endif
                                         @if($variant->qty == $variant->getTotalOrdered())
                                        {{ '0' }} @endif
                                        @if($variant->qty < $variant->getTotalOrdered())
                                        {{ $variant->getTotalOrdered() - $variant->qty }} @endif
                                        </span>@endif
                                    </td> -->
                                    <td>
                                        
                                        @if($variant->getTotalOrdered() !=0)
                                        @if(!empty($variant->total_required))
                                        <span class="label label-success">
                                            {{$variant->total_required}}
                                            </span>
                                         
                                          
                                          @endif
                                        @endif
                                    </td>
                                    <td>{{ $variant->getTotalFactoryOrdered() }}</td>
                                @endif
                            </tr>

                        @endforeach
                        <tr>
                            <td></td>
                            <th>Total</th>
                            <td colspan="5"><strong>Stock Qty: {{ $totalStock }}</strong>
                            @if(auth()->user()->isAdmin())
                                <br><strong>Stock Amount: {{ currency($totalStock * $product->price) }}</strong><br>

                            @endif
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div>
                    <nav id="paginationWrapper">
                        {!! sysView('includes.pagination', ['data' => $products]) !!}
                    </nav>
                </div>
            </div>
            <br/>

            @if(auth()->user()->isAdmin())
                <div class="alert alert-danger fade in block">
                    <a href="{{ sysUrl('products/clear/xl') }}">Clear Records</a> &nbsp;
                    <i class="icon-info"></i> This will clear all customer's orders/factory orders and all stock item
                    will
                    be set to 0
                </div>
            @endif

        </div>

    </div>

@stop

@section('scripts')
    <script>
        (function ($, window, document, undefined) {
            $(function () {
                $(document).on('change', '.product-stock', function (e) {
                    var url = $(this).data('url');
                    $.post(url, {
                        'qty': $(this).val()
                    }, function (response) {

                    })
                })
            });

        })(jQuery, window, document);
    </script>
@stop