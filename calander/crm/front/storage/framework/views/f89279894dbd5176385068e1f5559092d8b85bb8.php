<?php $i = 1; ?>
<?php foreach($products as $product): ?>
    <tr class="deleteBox">
        <td>
            <a href="<?php echo URL::route('webpanel.products.edit', array('id' => encrypt($product->id))); ?>"><?php echo e($product->name); ?></a>
        </td>
        <td>
            <img src="<?php echo e(asset($product->getThumbUrl())); ?>">
        </td>
        <td><?php echo e($product->height); ?>x<?php echo e($product->length); ?>x<?php echo e($product->depth); ?>cm</td>
        <td><?php echo e(@$product->collection->name); ?></td>
        <td><?php echo e(Config::get('currency.before')); ?><?php echo e(@$product->price); ?></td>
        <td><?php echo e(Config::get('currency.before')); ?><?php echo e(@$product->buying_price); ?></td>
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
<?php endforeach; ?>