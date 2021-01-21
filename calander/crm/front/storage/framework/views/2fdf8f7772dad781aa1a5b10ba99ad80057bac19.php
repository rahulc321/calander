<?php $__env->startSection('body'); ?>

    <div style="text-align: center">
        <span style="font-size:35px;font-weight:bold;">MORETTI MILANO</span>
    </div>

    <br/><br/>

    <table width="98%" cellspacing="0" cellpadding="4" border="0">
        <tr>
            <td width="50%" align="left" valign="top">
                Customer: <?php echo e($creditNote->user->fullName()); ?> <br/>
                Debitornr.: <?php echo e($creditNote->user->debitor_number); ?>

                <br/>

                <?php echo e(@$creditNote->user->address); ?>  <br/>
                <?php echo e(@$creditNote->user->zipcode); ?> <?php echo e(@$creditNote->user->city); ?> <br/>
                <?php echo e(@$creditNote->user->country); ?> <br/><br/>

                Status: <?php echo @\App\Modules\CreditNotes\CreditNote::$statusLabel[$creditNote->status]; ?> <br/>
                <?php if($creditNote->isDeclined()): ?>
                    <strong>Reason: </strong> <?php echo e($creditNote->status_text); ?><br>
                <?php endif; ?>
                <?php if($creditNote->isApproved() || $creditNote->isPaid()): ?>
                    <strong>Payment Type: </strong> <?php echo \App\Modules\CreditNotes\CreditNote::$paymentLabel[$creditNote->payment_type]; ?>

                    <br>
                <?php endif; ?>

            </td>

            <td width="50%" width="50%" align="left" valign="top">

                Lille Kongensgade 14, 1.sal <br/>
                1074 København K  <br/>
                Danmark  <br/>
                <br/>
                Kreditnotanr.:  <?php echo e(@$creditNote->id); ?> <br/>
                Kreditnotadato: <?php echo e($creditNote->createdDate()); ?>  <br/>

                CVR-nr.: 32048366 <br/>
                Telefon: +4522323640 <br/>
                Bank: Jyske Bank : 7851 1265999 <br/>
                Giro: SWIFT: JYBADKKK <br/>
                Kreditornr.: IBAN: DK5378510001265999 <br/>
                E-mail: info@morettimilano.com <br/>
                Webside: www.morettimilano.com <br/>
            </td>

        </tr>
    </table>

    <br/>

    <h4>Kreditnota</h4>
    <table width="98%" cellspacing="0" cellpadding="4" border="1">
        <thead>
        <tr>
            <th>SN</th>
            <th>Name</th>
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
                    <?php echo e(@$item->product->name); ?>

                </td>
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
            <?php if($creditNote->tax_percent > 0): ?>
                    <?php
                    $taxPercent = $creditNote->tax_percent;
                    ?>
                    <tr>
                        <th colspan="5" style="text-align: right;">Tax</th>
                        <th>
                            <?php echo e($taxPercent); ?>% (<?php echo e(currency(($grandTotal * ($taxPercent / 100)))); ?>)
                        </th>
                        
                    </tr>
                    <?php
                    $grandTotal += ($grandTotal * ($taxPercent / 100));
                    ?>
                <?php endif; ?>
                <tr>
                    <th colspan="5" style="text-align: right;">Grand Total</th>
                    <th>
                        <?php echo e(currency($grandTotal)); ?>

                    </th>
                </tr>
        
        </tfoot>
    </table>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('pdf.viewbase', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>