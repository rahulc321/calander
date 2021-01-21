@extends('webpanel.layouts.base')
@section('title')
Make Orders
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Make Order
                <small>Select product to make an order.</small>
            </h3>
        </div>
    </div>

    <div class="content">
        @include('webpanel.includes.notifications')

        <form method="get" action="" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Search</h3></div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-5">
                            <label for="keyword">Type Keyword:</label>
                            <input type="text" class="form-control" id="keyword" name="keyword"
                                   value="{{ Input::get('keyword') }}" required>
                        </div>

                        <div class="col-md-2" style="padding-top: 25px;">
                            <input type="submit" class="btn btn-primary btn-xs" name="filter" value="Filter">
                            <a class="btn btn-danger btn-xs" href="{{ sysRoute('orders.create') }}">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="panel panel-default">
            <div class="panel-body">
                @if($products->count() > 0)
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-3 text-center">
                                <a href="{{ sysUrl('products/item-for-order/'.encryptIt($product->id)) }}">
                                    <img src="{{ asset($product->getThumbUrl()) }}" style="min-height: 75px;">
                                </a>
                                <p style="font-size:14px;font-weight: bold;">{{ $product->name }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="paginationWrapper">
                        {!! $products->appends(Input::except('page'))->render() !!}
                    </div>
                @else
                    <div class="alert alert-info">No Products Found.</div>
                @endif
            </div>
        </div>
    </div>

@stop
