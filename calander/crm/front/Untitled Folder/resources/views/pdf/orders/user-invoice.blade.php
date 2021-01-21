@extends('pdf.viewbase')
@section('body')
<?php error_reporting(0); ?>
     

    <div style="text-align: center">
        <span style="font-size:30px;font-weight:bold;">MORETTI MILANO</span>
        <br/>
        <span style="font-size:20px;font-weight:bold;">INVOICE{{@$conversion}}</span>
    </div>

    <br/><br/>

    <table width="98%" cellspacing="0" cellpadding="4" border="0">
        <tr>
            <td width="70%">
               
                    Moretti Milano <br/>
                    Lille Kongensgade 14, 1 sal <br/>
                    1074 Copenhagen K <br/>
                    Denmark <br/>
                    <br/>
             

            </td>
            <td width="30%" valign="middle" align="left">
               
                    {{ @Auth::user()->fullName() }}&nbsp;(CID: {{ @$order->creator->debitor_number }})<br>
                    @if(@Auth::user()->address)
                    {{ @Auth::user()->address }} <br>
                    @endif
                     @if(@Auth::user()->zipcode)
                    {{ @Auth::user()->zipcode }} @endif @if(@Auth::user()->city){{ @Auth::user()->city }} <br/>@endif
                    
                    @if(@Auth::user()->country)
                    {{ @Auth::user()->country }} <br/>@endif
                    <br/>

                    Phone: {{ @Auth::user()->phone }} <br>
                
                    E-mail: {{ @Auth::user()->email }}<br>
               
                        Order ID#: {{ $order->OID }} <br/>
                      
               
            </td>
        </tr>
    </table>

    <br/> <br/>

    <table width="96%" cellspacing="0" cellpadding="4" border="1">
            <thead>
            <tr>
                <th>SN</th>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Image</th>
                <th>Color</th>
                <th>Size</th>
                <th style="width:100px;">Qty</th>
                <th style="width:100px;">Discount(%)</th>
                <th>Price</th>
                <th align="right">Total</th>
            </tr>
            </thead>
            <tbody>
            <?php $items = $order->items()->with('product.photos')->get(); $grandTotal = 0; ?>
            @foreach($items as $k => $item)
            
              <?php
             $folder= $item['product']['photos'][0]['media']['folder'];
             $fileName= $item['product']['photos'][0]['media']['filename'];

            ?>
                <tr class="deleteBox">
                    <td>
                        {{ $k + 1 }}
                    </td>
                    <td><strong>{{ @$item->product->name }}</strong></td>
                    <td>{{ @$item->variant->sku }}</td>
                    <td class=""><img src="https://crm.morettimilano.com/public/{{$folder.$fileName}}" alt=" " class="img-responsive" style="width: 56px;" onerror='this.onerror=null;this.src="<?php echo NO_IMG; ?>"'/></td>
                    <td>
                        {{ @$item->variant->color->name }}
                        <!--<div style="background: {{@$item->variant->color->hex_code }}; width:20px; height:20px;"></div>-->
                    </td>
                    <td>{{ @$item->product->length }} X {{ @$item->product->height }}</td>
                    <td>

                        {{ $item->qty }}

                    </td>
                    <td>
                        {{ $item->discount }}

                    </td>
                    <td>
                        {{ currency($item->price) }}
                    </td>
                    <?php $total = $item->getDiscountedPrice() * $item->qty; $grandTotal += $total; ?>
                    <td>{{ currency($total) }}</td>

                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th colspan="9" style="text-align: right;">Grand Total</th>
                <th>
                    {{ currency($grandTotal) }}
                </th>
               
            </tr>
            </tfoot>
        </table>
   <!-- *Please make payment in DKK(Danish Krone) If currency mentioned on Invoice is KR.-->
@stop
