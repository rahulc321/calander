@extends('pdf.viewbase')
@section('body')

    <div style="text-align: center">
        <span style="font-size:35px;font-weight:bold;">MORETTI MILANO</span>
    </div>

    <h4 style="text-align: center">PRODUCTS</h4>

    <table width="96%" cellspacing="0" cellpadding="4" border="1">
        <tr>
            <td>Name</td>
            <td>Image</td>
            <td>HEIGHT</td>
            <td>LENGTH</td>
            <td>Collection</td>
            <td>COLOR</td>
            <td>Selling Price</td>
            <td>Buying Price</td>
        </tr>
        <?php $i = 1; ?>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td><img src="{{ asset($product->getThumbUrl()) }}"></td>
                <td>{{ $product->height }}cm</td>
                <td>{{ $product->length }}cm</td>
                <td>{{ @$product->collection->name }}</td>
                <td>{{ $product->color }}</td>
                <td>{{Config::get('currency.before') }}{{ $product->price }}</td>
                <td>{{Config::get('currency.before') }}{{ $product->buying_price }}</td>
            </tr>
            <?php $i++; ?>
        @endforeach
        <tbody>
        </tbody>
    </table>

@stop
