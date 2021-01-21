<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<?php $invoice = $order->invoice; ?>

<div style="text-align: center">
    <img src="<?php echo e(asset('assets/images/moretti-leather-bags-logo-1.png')); ?>" height="90">
    <br/>
    <span style="font-size:20px;font-weight:bold;">INVOICE</span>
</div>

<br/><br/>

<table width="98%" cellspacing="0" cellpadding="4" border="0">
    <tr>
        <td width="70%">
            <?php if($order->creator->parent): ?>
                Moretti Milano <br/>
                Lille Kongensgade 14, 1 sal <br/>
                1074 Copenhagen K <br/>
                Denmark <br/>
                <br/>
                VAT nr: 32048366 <br/>
                Phone: +4522323640 <br/>
                Bank: Jyske Bank: 7851 1265999 <br/>
                IBAN : DK5378510001265999 <br/>
                SWIFT: JYBADKKK <br/>
                E-mail: info@morettimilano.com <br/>
                Website: www.morettimilano.com <br/>
            <?php endif; ?>

        </td>
        <td width="30%" valign="middle" align="left">
            <?php if(@$order->creator): ?>
                <?php echo e(@$order->creator->fullName()); ?> <br>
                <?php echo e(@$order->creator->address); ?> <br>
                <?php echo e(@$order->creator->zipcode); ?> <?php echo e(@$order->creator->city); ?> <br/>
                <?php echo e(@$order->creator->country); ?> <br/>
                <br/>
                Phone: <?php echo e(@$order->creator->phone); ?> <br>
                VAT nr: <?php echo e(@$order->creator->vat_number); ?> <br>
                E-mail: <?php echo e(@$order->creator->email); ?>

            <?php endif; ?>

            <?php if($order->invoice): ?>
                Invoice nr#: <?php echo e(@$order->invoice->IID); ?> <br/>
                Invoice Date: <?php echo e(date("d/m/Y", strtotime(@$order->invoice->issue_date))); ?> <br/>
                Due Date:  <?php echo e(date("d/m/Y", strtotime(@$order->due_date))); ?>

            <?php endif; ?>
        </td>
    </tr>
</table>

<br/> <br/>

<table width="96%" cellspacing="0" cellpadding="4" border="1">
    <thead>
    <tr>
        <th>SN</th>
        <th>Product Name</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    <?php $items = $order->items()->with('product.photos')->get(); $grandTotal = 0; ?>
    <?php foreach($items as $k => $item): ?>
        <tr>
            <td>
                <?php echo e($k + 1); ?>

            </td>
            <td><?php echo e(@$item->product->name); ?></td>
            <td align="right"> <?php echo e($item->qty); ?></td>
            <td align="right"> <?php echo e(currency($item->price)); ?> </td>
            <?php $total = $item->price * $item->qty; $grandTotal+=$total; ?>
            <td align="right"><?php echo e(currency($total)); ?></td>
        </tr>

    <?php endforeach; ?>

    </tbody>
    <tfoot>
    <tr>
        <th colspan="4" style="text-align: right;">Total</th>
        <th align="right">
            <?php echo e(currency($grandTotal)); ?>

        </th>
    </tr>
    <?php if($order->tax_percent > 0): ?>
        <?php
        $taxPercent = $order->tax_percent;
        ?>
        <tr>
            <th colspan="4" style="text-align: right;">Tax</th>
            <th align="right">
                <?php echo e($taxPercent); ?>% (<?php echo e(currency(($grandTotal * ($taxPercent / 100)))); ?>)
            </th>
        </tr>
        <?php
        $grandTotal += ($grandTotal * ($taxPercent / 100));
        ?>
    <?php endif; ?>
    <tr>
        <th colspan="4" style="text-align: right;">Shipping Price</th>
        <th align="right">
            <?php echo e(currency($order->shipping_price)); ?>

        </th>
    </tr>
    <?php if($order->getCreditNoteAmount() > 0): ?>
        <tr>
            <th colspan="4" style="text-align: right;">Credit Note Amount</th>
            <th align="right"><?php echo e(currency($order->getCreditNoteAmount())); ?></th>
        </tr>
    <?php endif; ?>
    <tr>
        <th colspan="4" style="text-align: right;">Grand Total</th>
        <th align="right">
            <?php echo e(currency($order->getTotalPrice() - $order->getCreditNoteAmount())); ?>

        </th>
    </tr>
    </tfoot>
</table>

</body>
</html>