<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>


<div style="text-align: center">
    <img src="<?php echo e(asset('assets/images/moretti-leather-bags-logo-1.png')); ?>" height="90">
    <br/>
    <!--<small style="font-size:12px;">MORETTI MILANO</small>-->
</div>

<br/><br/>

<table width="96%" cellspacing="0" cellpadding="4" border="0">
    <tr>
        <td>
            Order Status: <?php echo @\App\Modules\Orders\Order::$statusLabel[$order->status]; ?> <br/>
            ORDER#: <?php echo e($order->OID); ?>

        </td>
        <td>
            Order Date: <?php echo e($order->createdDate()); ?> <br/>
            Customer:  }}
            <!-- {{ $order->creator->fullName() -->
        </td>
    </tr>
</table>

<br/> <br/>

<p align="center">Order Details</p>

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
            <?php foreach($items as $k => $item): ?>
                <tr class="deleteBox">
                    <td>
                        <?php echo e($k + 1); ?>

                    </td>
                    <td><strong><?php echo e(@$item->product->name); ?></strong></td>
                    <td><?php echo e(@$item->variant->sku); ?></td>
                    <td>
                        <img src="<?php echo e($item->product->getThumbUrl()); ?>">
                    </td>
                    <td>
                        <?php echo e(@$item->variant->color->name); ?>

                        <!--<div style="background: <?php echo e(@$item->variant->color->hex_code); ?>; width:20px; height:20px;"></div>-->
                    </td>
                    <td><?php echo e(@$item->product->length); ?> X <?php echo e(@$item->product->height); ?></td>
                    <td>

                        <?php echo e($item->qty); ?>


                    </td>
                    <td>
                        <?php echo e($item->discount); ?>


                    </td>
                    <td>
                        <?php echo e(currency($item->price)); ?>

                    </td>
                    <?php $total = $item->getDiscountedPrice() * $item->qty; $grandTotal += $total; ?>
                    <td><?php echo e(currency($total)); ?></td>

                </tr>
            <?php endforeach; ?>

            </tbody>
            <tfoot>
            <tr>
                <th colspan="9" style="text-align: right;">Grand Total</th>
                <th>
                    <?php echo e(currency($grandTotal)); ?>

                </th>
                <th></th>
            </tr>
            </tfoot>
        </table>

</body>
</html>