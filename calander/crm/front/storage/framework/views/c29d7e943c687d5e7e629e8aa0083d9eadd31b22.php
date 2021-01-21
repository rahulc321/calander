<?php $__env->startSection('title'); ?>
Commission
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Commission</h3>
        </div>
    </div>

    <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('webpanel.invoices.partials.commission-filter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="content">
            <?php
            $totalCommission = 0;
            $paidCommission = 0;
            foreach ($totalInvoices as $inv) {
                if ($inv->order->salesPerson):
                    $commission = percentOf($inv->order->salesPerson->commission, $inv->order ? $inv->order->getTotalWithoutShipping() : 0);
                    if($inv->isCommissionPaid()){
                        $paidCommission += $commission;
                    }
                    $totalCommission += $commission;
                endif;
            }
            ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">Commission</h6>
                <span class="pull-right badge">Total Commission: <?php echo e(currency($paidCommission)); ?> paid out of <?php echo e(currency($totalCommission)); ?></span>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-invoiceBy="OID">Invoice ID</th>
                        <th class="sortableHeading" data-invoiceBy="created_by">Issued To</th>
                        <th data-invoiceBy="">Issue Date</th>
                        <th data-invoiceBy="">Due Date</th>
                        <th data-invoiceBy="status">Commission Status</th>
                        <th>Total Amount</th>
                        <th>Commission</th>
                        <?php if(auth()->user()->isAdmin()): ?>
                            <th>Action</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php echo sysView('invoices.partials.commission-list', compact('invoices')); ?>

                    </tbody>
                </table>
                <div>
                    <nav id="paginationWrapper">
                        <?php echo $invoices->appends(Input::except('page'))->render(); ?>

                    </nav>
                </div>
            </div>
        </div>

    </div>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        (function ($, window, document, undefined) {
            $(function () {
                $(document).on('change', '.toggleStatus', function (e) {
                    window.location = $(this).data('url');
                })
            });
        })(jQuery, window, document);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>