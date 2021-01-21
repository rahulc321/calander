<?php $__env->startSection('title'); ?>
Kreditnota
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Kreditnota</h3>
        </div>
        <div class="pull-right">
            <br/>
            <a href="<?php echo e(sysRoute('creditnotes.create')); ?>" class="btn btn-warning btn-sm pull-right">+ Add</a>
        </div>
    </div>

    <div class="content">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <br/>
        <?php if(auth()->user()->isAdmin()): ?>
            <?php echo $__env->make('webpanel.creditnotes.partials.search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>

        <?php if($selectedUser): ?>
            <div class="alert alert-success">
                <?php $userCreditNotes = $selectedUser->creditNotes()->approved()->where('payment_type', '=', \App\Modules\CreditNotes\CreditNote::PAYMENT_TYPE_BILLING)->get(); ?>
                Total Remaining: <?php echo e(currency($userCreditNotes->sum('total') - $userCreditNotes->sum('paid'))); ?>

            </div>
        <?php endif; ?>
        <div>

            <div class="panel-body">
                <table class="table table-bordered table-striped ajaxTable deleteArena"
                       data-request-url="<?php echo route('webpanel.creditnotes.index'); ?>">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Customer</th>
                        <th width="30%">Note</th>
                        <th class="sortableHeading" data-orderBy="created_at">Date</th>
                        <th class="sortableHeading" data-orderBy="price">Kreditnota Price</th>
                        <th class="sortableHeading" data-orderBy="price">Received</th>
                        <th data-orderBy="status">Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div>
                    <nav id="paginationWrapper"></nav>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>