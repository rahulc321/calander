<?php $__env->startSection('body'); ?>

    <div style="text-align: center">
        <span style="font-size:35px;font-weight:bold;">MORETTI MILANO</span>
    </div>

    <br/> <br/>
    <?php if($order->creator): ?>
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
                        Webside: www.morettimilano.com <br/>
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
                        VAT nr: <?php echo e(@$order->creator->vat_number); ?>

                        E-mail: <?php echo e(@$order->creator->email); ?> <br>
                    <?php endif; ?>

                    Order Date: <?php echo e($order->createdDate('d/m/Y')); ?>

                    <?php if($order->hasExpectedShippingDate()): ?>
                        <br>
                        <strong>Expected Shipping Date : </strong>
                        <?php echo e($order->expected_shipping_date->format("d/m/Y")); ?>

                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <br/><br/>

        <table width="98%" cellspacing="0" cellpadding="4" border="1">
            <thead>
            <tr>
                <th>SN</th>
                <th>Product Name</th>
                <th>Color</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <?php $items = $order->items()->with('product.photos')->get(); $grandTotal = 0; ?>

            <?php foreach($items as $k => $item): ?>
                <tr>
                    <td><?php echo e($k + 1); ?> </td>
                    <td><?php echo e(@$item->product->name); ?></td>
                    <td><?php echo e(@$item->variant->color->name); ?>&nbsp;&nbsp;<?php if($item->note!=''): ?>Note:<?php echo e($item->note); ?><?php else: ?>
                                <?php endif; ?></td>
                    <td align="right"> <?php echo e($item->qty); ?> </td>
                    <td align="right"> <?php echo e($order->getInCurrency($item->price)); ?> </td>
                    <td align="right"> <?php echo e($item->discount); ?> %</td>
                    <?php $total = $item->getDiscountedPrice() * $item->qty; $grandTotal += $total; ?>
                    <td align="right"><?php echo e($order->getInCurrency($total)); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <th colspan="6" style="text-align: right;">Total</th>
                <th align="right">
                    <?php echo e($order->getInCurrency($grandTotal)); ?>

                </th>
            </tr>
            <?php if($order->tax_percent > 0): ?>
                <?php
                $taxPercent = $order->tax_percent;
                ?>
                <tr>
                    <th colspan="6" style="text-align: right;">Tax</th>
                    <th align="right">
                        <?php echo e($taxPercent); ?>% (<?php echo e(currency(($grandTotal * ($taxPercent / 100)))); ?>)
                    </th>
                </tr>
                <?php
                $grandTotal += ($grandTotal * ($taxPercent / 100));
                ?>
            <?php endif; ?>

            <?php if($order->toRefund): ?>
                <?php $refund = $order->toRefund->getRefundAmount();
                $grandTotal -= $refund;
                ?>
                <tr>
                    <th colspan="6" style="text-align: right;">Refund Deduction</th>
                    <th align="right">
                        <?php echo e($order->getInCurrency($refund)); ?>

                    </th>
                </tr>
            <?php endif; ?>
            <tr>
                <th colspan="6" style="text-align: right;">Shipping Price</th>
                <th align="right">
                    <?php echo e($order->getInCurrency($order->shipping_price)); ?>

                </th>
            </tr>
            <?php if($order->getCreditNoteAmount() > 0): ?>
                <tr>
                    <th colspan="6" style="text-align: right;">Kreditnota</th>
                    <th align="right"><?php echo e(currency($order->getCreditNoteAmount())); ?></th>
                </tr>
            <?php endif; ?>
            <tr>
                <th colspan="6" style="text-align: right;">Grand Total</th>
                <th align="right">
                    <?php echo e(currency($order->getTotalPrice() - $order->getCreditNoteAmount())); ?>

                </th>
            </tr>
            </tfoot>
        </table>

    <?php else: ?>
        <h3>INVALID ORDER</h3>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('pdf.viewbase', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>