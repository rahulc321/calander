<!DOCTYPE html>
<html lang="en-US">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
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
            Customer:  <?php echo e($order->creator->fullName()); ?>

              
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
            
             <?php
             $folder= $item['product']['photos'][0]['media']['folder'];
             $fileName= $item['product']['photos'][0]['media']['filename'];

            ?>
                <tr class="deleteBox">
                    <td>
                        <?php echo e($k + 1); ?>

                    </td>
                    <td><strong><?php echo e(@$item->product->name); ?></strong></td>
                    <td><?php echo e(@$item->variant->sku); ?></td>
                   <td class=""><img src="https://crm.morettimilano.com/public/<?php echo e($folder.$fileName); ?>" alt=" " class="img-responsive" style="width: 56px;" onerror='this.onerror=null;this.src="<?php echo NO_IMG; ?>"'/></td>
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
                        <!--<?php echo e(currency($item->price)); ?>-->
                        €<?php echo e(number_format($item->price/euro()->conversion,2)); ?>

                    </td>
                    <?php $total = $item->getDiscountedPrice() * $item->qty; $grandTotal += $total; ?>
                    <td>
                        <!--<?php echo e(currency($total)); ?>-->
                        €<?php echo e(number_format($total/euro()->conversion,2)); ?>

                    </td>

                </tr>
            <?php endforeach; ?>

            </tbody>
            <tfoot>
            <tr>
                <th colspan="9" style="text-align: right;">Grand Total</th>
                <th>
                    <!--<?php echo e(currency($grandTotal)); ?>-->
                    €<?php echo e(number_format($grandTotal/euro()->conversion,2)); ?>

                </th>
                <th></th>
            </tr>
            </tfoot>
        </table>

</body>
</html>