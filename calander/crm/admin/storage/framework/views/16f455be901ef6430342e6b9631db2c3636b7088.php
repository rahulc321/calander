<?php $__env->startSection('body'); ?>
<?php error_reporting(0); ?>
    <?php $order = $invoice->order; ?>

    <div style="text-align: center">
        <span style="font-size:30px;font-weight:bold;">MORETTI MILANO</span>
        <br/>
        <span style="font-size:20px;font-weight:bold;">INVOICE<?php echo e(@$conversion); ?></span>
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
                    <?php echo e(@$order->creator->fullName()); ?>&nbsp;(CID: <?php echo e(@$order->creator->debitor_number); ?>)<br>
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
                        <td>
                            <?php echo e($k + 1); ?>

                        </td>
                        <td><?php echo e(@$item->product->name); ?></td>
                        <td><?php echo e(@$item->variant->color->name); ?></td>
                        <td align="right"> <?php echo e($item->qty); ?></td>
                        <td align="right">
                            <?php if(!empty(@$conversion)): ?>

                            <?php echo e(@$symbol); ?> <?php echo e(number_format($item->price/$conversion,2)); ?>

                            <?php else: ?>
                            <?php echo e(currency($item->price)); ?>

                            <?php endif; ?>
                            </td>
                        <td align="right">
                            <?php if(!empty(@$conversion)): ?>

                            <?php echo e(@$symbol); ?> <?php echo e(number_format($item->discount/$conversion,2)); ?>

                            <?php else: ?>
                            <?php echo e($item->discount); ?>

                            <?php endif; ?>


                         </td>
                        <?php $total = $item->getDiscountedPrice() * $item->qty; $grandTotal+=currency_without_name($total); ?>
                        <td align="right">

                            <?php if(!empty(@$conversion)): ?>

                            <?php echo e(@$symbol); ?> <?php echo e(number_format($total/$conversion,2)); ?>

                            <?php else: ?>
                            <?php echo e(currency($total)); ?>

                            <?php endif; ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

                </tbody>
                <tfoot>
                <tr>
                    <th colspan="6" style="text-align: right;">Total</th>
                    <th align="right">
                            <?php if(!empty(@$conversion)): ?>

                                <?php echo e(@$symbol); ?> <?php echo e(number_format($grandTotal/$conversion,2)); ?>

                            <?php else: ?>
                                <?php echo e($order->getInCurrency($grandTotal)); ?>

                            <?php endif; ?>


                        
                    </th>
                </tr>
            <?php if($order->tax_percent > 0): ?>
                    <?php
                    $taxPercent = $order->tax_percent;
                    ?>
                    <tr>
                        <th colspan="6" style="text-align: right;">Tax</th>
                        <th align="right">
                            <?php $tax1= $grandTotal * ($taxPercent / 100) ?>

                            <?php if(!empty(@$conversion)): ?>

                                <?php echo e($taxPercent); ?>% <?php echo e(@$symbol); ?> <?php echo e(number_format($tax1/$conversion,2)); ?>

                            <?php else: ?>
                                <?php echo e($taxPercent); ?>% (<?php echo e(currency($tax1)); ?>)
                            <?php endif; ?>

                            
                        </th>
                    </tr>
                    <?php
                    $grandTotal += ($grandTotal * ($taxPercent / 100));
                    ?>
                <?php endif; ?>
                <tr>
                    <th colspan="6" style="text-align: right;">Shipping Price</th>
                    <th align="right">
                        <!--<?php echo e($order->getInCurrency($order->shipping_price)); ?>-->

                        <?php if(!empty(@$conversion)): ?>

                            <?php echo e(@$symbol); ?> <?php echo e(number_format($order->shipping_price/$conversion,2)); ?>

                        <?php else: ?>
                            <?php echo e(currency($order->shipping_price)); ?>

                        <?php endif; ?>

                       
                    </th>
                </tr>
                <?php if($order->getCreditNoteAmount() > 0): ?>
                    <tr>
                        <th colspan="6" style="text-align: right;">Credit Note Amount</th>
                        <th align="right">
                            <?php if(!empty(@$conversion)): ?>

                                <?php echo e(@$symbol); ?> <?php echo e(number_format($order->getCreditNoteAmount()/$conversion,2)); ?>

                            <?php else: ?>
                                <?php echo e(currency($order->getCreditNoteAmount())); ?>

                            <?php endif; ?>
                            </th>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th colspan="6" style="text-align: right;">Grand Total</th>
                    <th align="right">
                        <?php $grandTotal1= $order->getTotalPrice() - $order->getCreditNoteAmount() ?>

                        <?php if(!empty(@$conversion)): ?>

                            <?php echo e(@$symbol); ?> <?php echo e(number_format($grandTotal1/$conversion,2)); ?>

                        <?php else: ?>
                            <?php echo e(currency($grandTotal1)); ?>

                        <?php endif; ?>

                        
                    </th>
                </tr>
                </tfoot>
    </table>
   <!-- *Please make payment in DKK(Danish Krone) If currency mentioned on Invoice is KR.-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pdf.viewbase', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>