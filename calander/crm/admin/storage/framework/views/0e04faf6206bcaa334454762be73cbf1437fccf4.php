<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>


<div style="text-align: center">
    <img src="<?php echo e(asset('assets/images/moretti-leather-bags-logo-1.png')); ?>" height="90">
    <br/>
   <!-- <small style="font-size:12px;">MORETTI MILANO</small>-->
</div>

<br/><br/>

<table width="96%" cellspacing="0" cellpadding="4" border="0">
    <tr>
        <td>
            Status: <?php echo @\App\Modules\CreditNotes\CreditNote::$statusLabel[$creditNote->status]; ?> <br/>
            <?php if($creditNote->isDeclined()): ?>
                <strong>Reason : </strong> <?php echo e($creditNote->status_text); ?><br>
            <?php endif; ?>
            <?php if($creditNote->isApproved() || $creditNote->isPaid()): ?>
                <strong>Payment Type
                    : </strong> <?php echo \App\Modules\CreditNotes\CreditNote::$paymentLabel[$creditNote->payment_type]; ?>

                <br>
            <?php endif; ?>
        </td>
        <td>
            Date: <?php echo e($creditNote->createdDate()); ?> <br/>
            Customer: <?php echo e($creditNote->user->fullName()); ?>

        </td>
    </tr>
</table>

<br/> <br/>

<p align="center">Order Details</p>

<table width="96%" cellspacing="0" cellpadding="4" border="1">
    <thead>
    <thead>
    <tr>
        <th>SN</th>
        <th>Name</th>
        <th>Image</th>
        <th>Color</th>
        <th>Price</th>
        <th style="width:100px;">QTY</th>
        <th align="right">Total</th>
    </tr>
    </thead>
    <tbody>
    <?php $items = $creditNote->items()->with('product.photos')->get();
    $grandTotal = 0; ?>
    <?php foreach($items as $k => $item): ?>
        <tr class="deleteBox">
            <td>
                <?php echo e($k + 1); ?>

            </td>
            <td>
                <?php echo e(@$item->product->name); ?> <br/>
                <?php echo e(@$item->variant->sku); ?>

            </td>
            <td><img src="<?php echo e($item->product->getThumbUrl()); ?>"></td>
            <td>
                <?php echo e(@$item->variant->color->name); ?>

            </td>
            <td><?php echo e(currency($item->price)); ?></td>
            <td><?php echo e($item->qty); ?></td>

            <?php
            $total = $item->price * $item->qty;
            $grandTotal += $total; ?>
            <td><?php echo e(currency($total)); ?></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="5"></th>
        <th>
            <?php echo e($creditNote->items->sum('qty')); ?>

        </th>
        <th></th>
    </tr>
    <tr>
        <th colspan="6" style="text-align: right;">Grand Total</th>
        <th>
            <?php echo e(currency($grandTotal)); ?>

        </th>
    </tr>
</table>

</body>
</html>