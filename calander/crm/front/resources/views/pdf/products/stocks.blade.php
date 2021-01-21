@extends('pdf.viewbase')
@section('body')

    <div style="text-align: center">
        <span style="font-size:35px;font-weight:bold;">MORETTI MILANO</span>
    </div>

    <h4 style="text-align: center">STOCKS</h4>

    <table width="96%" cellspacing="0" cellpadding="4" border="1">
        <tr>
            <td>SN</td>
            <td>Image/Product</td>
            <td>Color/SKU/QTY</td>
        </tr>
        <tbody>
        @foreach($products as $k => $product)
            <tr>
                <td>{{ $k + 1 }}</td>
                <td align="center">
                    <img src="{{ asset($product->getThumbUrl()) }}"> <br/>
                    {{ $product->name }}
                </td>
                <td>
                    <table width="95%">
                        @foreach($product->variants as $variant)
                            <tr>
                                <td width="10%">
                                    <div style="background: {{@$variant->color->hex_code }}; width:20px; height:20px;"></div>
                                </td>
                                <td width="50%">{{ $variant->sku }}</td>
                                <td width="30%">{{ $variant->qty }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@stop
