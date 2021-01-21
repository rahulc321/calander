<?php $__env->startSection('body'); ?>
<?php error_reporting(0); ?>
     

    <div style="text-align: center">
        <span style="font-size:30px;font-weight:bold;">MORETTI MILANO</span>
        <br/>
        <span style="font-size:20px;font-weight:bold;">INVOICE<?php echo e(@$conversion); ?></span>
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
               
                    <?php echo e(@Auth::user()->fullName()); ?>&nbsp;(CID: <?php echo e(@$order->creator->debitor_number); ?>)<br>
                    <?php if(@Auth::user()->address): ?>
                    <?php echo e(@Auth::user()->address); ?> <br>
                    <?php endif; ?>
                     <?php if(@Auth::user()->zipcode): ?>
                    <?php echo e(@Auth::user()->zipcode); ?> <?php endif; ?> <?php if(@Auth::user()->city): ?><?php echo e(@Auth::user()->city); ?> <br/><?php endif; ?>
                    
                    <?php if(@Auth::user()->country): ?>
                    <?php echo e(@Auth::user()->country); ?> <br/><?php endif; ?>
                    <br/>

                    Phone: <?php echo e(@Auth::user()->phone); ?> <br>
                
                    E-mail: <?php echo e(@Auth::user()->email); ?><br>
               
                        Order ID#: <?php echo e($order->OID); ?> <br/>
                      
               
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
               
            </tr>
            </tfoot>
        </table>
   <!-- *Please make payment in DKK(Danish Krone) If currency mentioned on Invoice is KR.-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('pdf.viewbase', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>