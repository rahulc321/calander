@extends('webpanel.layouts.base')
@section('title')
    Product: {{ $product->name }}
    @parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Product: {{ $product->name }}
                <small>Select required Qty and Process.</small>
            </h3>
        </div>
        <div class="range">
            <?php
            $previousProduct = false;
            $previous = \App\Modules\Products\Product::where('id', '<', $product->id)->max('id');
            if ($previous) {
                $previousProduct = \App\Modules\Products\Product::find($previous);
            }

            // get next user id
            $nextProduct = false;
            $next = \App\Modules\Products\Product::where('id', '>', $product->id)->min('id');
            if ($next) {
                $nextProduct = \App\Modules\Products\Product::find($next);
            }
            ?>
            @if($previousProduct)
                <a href="{{ sysUrl('products/item-for-order/'.encryptIt($previous)) }}"
                   class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Previous</a>
            @endif

            @if($nextProduct)
                <a href="{{ sysUrl('products/item-for-order/'.encryptIt($next)) }}"
                   class="btn btn-warning btn-sm">Next <i class="fa fa-arrow-right"></i> </a>
            @endif
        </div>
    </div>

    <div class="content">
        <form class="ajaxForm form-horizontal" method="post" enctype="multipart/form-data"
              action="<?php echo sysUrl('orders/add-to-cart'); ?>"
              role="form" data-result-container="#notificationArea">
            <input type="hidden" name="id" value="{{ encryptIt($product->id) }}">

            <div class="panel">
                <div class="panel-body">
                    @include('webpanel.includes.notifications')
                    <div class="row">
                        <div class="col-md-6">
                        <?php $i=1; ?>
                        @foreach($product->photos as $k => $photo)
                            @if ($i==1)
                             <img src="{{ $photo->getFileUrl()}}" data-lazy="{{ $photo->getFileUrl() }}" style="width:100%;"/>
                            @endif
                        <?php $i++; ?>
                        @endforeach

                        </div>
                        <div class="col-md-6">
                            <strong>{{ currency($product->price) }}</strong><br>
                            <div class="row">
                                <div class="col-md-3">
                                    <input class="form-control" name="qty" value="1" pattern="[0-9]+">
                                </div>
                                <span class="help-block" id="stock-label"></span>
                            </div>

                            <br/><br/>
                           <strong>Select Colors:</strong><br><br/>

                            <div class="row">
                                <div class="col-md-7">
                                    <input type="hidden" name="variant_id" value="">
                                    <?php $variants = $product->variants()->with('color')->get(); ?>
                                    @if($variants->count() > 0)
                                        @foreach($variants as $variant)
                                            <?php if (!$variant->color): continue; endif;?>
                                            <a class="color-box" style="background:{{ @$variant->color->hex_code }}"
                                               data-stock-label="{{ $variant->qty > 0 ? 'In Stock' : 'Out Of Stock' }}"
                                               data-id="{{ $variant->id }}" title="{{ @$variant->color->name }}"></a>
                                        @endforeach
                                    @endif
                                </div>

                            </div>
                            <br>
                            <div style="padding-left:0px;">
                                <button type="submit" class="btn btn-success">Add To Cart</button>
                            </div>
                            <br/>
                            <strong>Description:</strong><br>
                            <p>{{ $product->description }}</p>
                            <strong>Dimensions:</strong> <br/>
                            Length: {{ $product->length }} cm <br/>
                            Height: {{ $product->height }} cm <br/>
                            Depth: {{ $product->depth }} cm <br/>
                            <hr/>
                            Number of Compartments: {{ $product->number_of_compartments }} <br/>
                            Number of Pockets: {{ $product->number_of_pockets }} <br/>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
@stop

@section('scripts')
    <script>
        (function ($, window, document, undefined) {
            $(function () {
                $(".color-box").on('click', function (e) {
                    $("[name=variant_id]").val($(this).attr('data-id'));
                    $("#stock-label").text($(this).attr('data-stock-label'));
                    $(".color-box").removeClass('active');
                    $(this).addClass('active');
                    return false;
                });
            });
        })(jQuery, window, document);
    </script>
@stop