<?php $__env->startSection('title'); ?>
Invoices
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Invoices</h3>
        </div>
    </div>

    <div class="content">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('webpanel.invoices.partials.search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="hpanel">
            <div class="panel-body">
                (Unpaid = <?php echo e(currency(@$totalUnpaid)); ?>) <br />  (Paid = <?php echo e(currency(@$totalpaid)); ?>) <a href="<?php echo e(sysUrl('invoices/download-all/xl')); ?>?<?php echo e(http_build_query(Input::except('page'))); ?>" class="pull-right btn"><i class="icon-print2"></i> Print</a>

                <table class="table table-bordered  table-binvoiceed deleteArena"
                       data-request-url="<?php echo route('webpanel.invoices.index'); ?>">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-invoiceBy="OID">Invoice ID</th>
                        <th class="sortableHeading" data-invoiceBy="created_by">Issued To</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Due Expired</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                        <?php if(auth()->user()->isSales() OR auth()->user()->isAdmin()): ?>
                            <th>Commission</th>
                        <?php endif; ?>
                        <?php if(auth()->user()->isAdmin()): ?>
                            <th>Action</th>
                        <?php endif; ?>
                        <th>Download</th>
                    </tr>
                    </thead>
                    <?php echo sysView('invoices.partials.list', compact('invoices')); ?>

                    <tbody>
                    </tbody>
                </table>

                <div>
                    <nav id="paginationWrapper" class="pagination-sm">
                        <?php echo $invoices->appends(Input::except('page'))->render(); ?>

                    </nav>
                </div>
            </div>
            <div>
                <?php if(auth()->user()->isSales()): ?>
                    <div class="sales-container">
                        <strong>Total Commission Earned:</strong>
                        <?php
                        $totalAmount = \App\Modules\Invoices\Invoice::forMe()->paid()
                                ->leftJoin('orders', 'invoices.order_id', '=', 'orders.id')->sum('price');
                        echo $totalAmount > 0 ? currency(percentOf(auth()->user()->commission, $totalAmount)) : currency(0);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        (function ($, window, document, undefined) {
            $(function () {
                $(document).on('change', '.toggleStatus', function (e) {
                    if(confirm("Are you sure you want to perform this action ?")){
                        window.location = $(this).data('url')+'/'+$(this).val();
                    }
                    else{
                        window.location.reload();
                    }

                })
            });
        })(jQuery, window, document);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>