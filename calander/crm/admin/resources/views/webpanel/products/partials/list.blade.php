<?php $i = 1; ?>
@foreach($products as $product)
    <tr class="deleteBox">
        <td>
            <a href="<?php echo URL::route('webpanel.products.edit', array('id' => encrypt($product->id))); ?>">{{ $product->name }}</a>
        </td>
        <td>
            <img src="{{ asset($product->getThumbUrl()) }}">
        </td>
        <td>{{ $product->height }}x{{$product->length }}x{{$product->depth }}cm</td>
        <td>{{ @$product->collection->name }}</td>
        <td>{{Config::get('currency.before') }}{{ @$product->price }}</td>
        <td>{{Config::get('currency.before') }}{{ @$product->buying_price }}</td>
        <td>
            <a title="Edit Product"
               href="<?php echo URL::route('webpanel.products.edit', array('id' => encrypt($product->id))); ?>"
               class=""><i class="icon-pencil3"></i>
            </a>
            <a title="Delete Product"
               href="#"
               class="ajaxdelete"
               data-id="<?php echo $product->id; ?>"
               data-url="<?php echo sysUrl('products/delete/' . encrypt($product->id)); ?>"
               data-token="<?php echo urlencode(md5($product->id)); ?>"><i class="icon-remove3"></i>
            </a>
        </td>
    </tr>
    <?php $i++; ?>
@endforeach