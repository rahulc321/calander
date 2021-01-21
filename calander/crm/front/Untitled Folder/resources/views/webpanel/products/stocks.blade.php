@extends('webpanel.layouts.base')
@section('title')
Stocks
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>View Stock Details
            </h3>
        </div>
        <div class="range">
            <a class="btn btn-success btn-sm pull-right" href="{{ sysUrl('products/download-stocks/xl') }}"><i class="icon-print2"></i> Print</a>
        </div>
    </div>

    <div class="content">
        @include('webpanel.includes.notifications')

        <div class="table-responsive">
            <table class="table table-bordered table-condensed deleteArena">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Image/Product</th>
                    <th>Color/SKU/QTY</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $k => $product)
                    <tr>
                        <td align="center">{{ $k + 1 }}</td>
                        <td align="center">
                            <img src="{{ asset($product->getThumbUrl()) }}"> <br/>
                            <strong><a href="<?php echo URL::route('webpanel.products.edit', array('id' => encrypt($product->id))); ?>">{{ $product->name }}</a></strong>
                        </td>
                        <td>
                            <table class="table table-bordered">
                                @foreach($product->variants as $variant)
                                    <tr>
                                        <td width="25%">
                                            {{@$variant->color->name }}
                                            <div style="background: {{@$variant->color->hex_code }}; width:20px; height:20px;"></div>
                                        </td>
                                        <td width="25%">{{ $variant->sku }}</td>
                                        <td width="25%"><span class="label label-success">{{ $variant->qty }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop
