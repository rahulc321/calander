<?php $__env->startSection('title'); ?>
Add Kreditnota
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Add Kreditnota</h3>
        </div>
    </div>

    <div class="content">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <form method="post" action="<?php echo e(sysRoute('creditnotes.store')); ?>" class="ajaxForm form-horizontal">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">Add</h6>
                </div>

                <div class="panel-body">

                <?php if(auth()->user()->isAdmin()): ?>
                    <div class="form-group">
                        <label class="control-label col-md-2" for="user_id">Customer:</label>
                        <div class="col-md-5">
                            <select class="select2 lazySelector" id="user_id" name="user_id" style="min-width: 400px;"
                                    data-selected="<?php echo e(Input::get('user_id')); ?>">
                                <option value=""></option>
                                <?php echo OptionsView(\App\User::customers()->alphabetical()->get(), 'id', function($item){ return $item->fullName(); }); ?>

                            </select>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="user_id" value="<?php echo e(auth()->user()->id); ?>">
                <?php endif; ?>

                <div class="form-group">
                        <label class="control-label col-md-2" for="note">Note (Memo):</label>
                        <div class="col-md-5">
                            <textarea class="form-control" id="note" name="note"><?php echo e(Input::get('note')); ?></textarea>
                        </div>
                </div>
                    </div>
            </div>

                <a id="add-row" class="btn btn-primary btn-xs">+ Add Item</a> <br/> <br/>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Variant</th>
                        <th width="120">Qty</th>
                        <th  width="100">Action</th>
                    </tr>
                    </thead>
                    <tbody id="credit-container">
                    <tr>
                        <td>
                            <select name="product_id[]" class="form-control blank product" required
                                    data-url="<?php echo e(sysUrl('products/variants-ajax')); ?>">
                                <option value="">Select</option>
                                <?php echo OptionsView(\App\Modules\Products\Product::all(), 'id', 'name'); ?>

                            </select>
                        </td>
                        <td>
                            <select name="variant_id[]" class="form-control variant empty" required>
                                <option value="">Select</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="qty[]" class="form-control blank" required>
                        </td>
                        <td>
                            <a class="remove-row btn-xs btn-danger"><i class="icon icon-remove3"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <br/>
                <input type="submit" class="btn btn-primary" name="save" value="Save">
        </form>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        (function ($, window, undefined) {
            $(function () {

                var $container = $("#credit-container");
                $("#add-row").click(function (e) {
                    var row = $container.find('tr:last').clone(true);
                    row.find('.blank').val('');
                    row.find('.empty').find('option').remove();
                    $container.append(row);
                    e.preventDefault();
                    return false;
                });

                $(document).on('change', '.product', function (e) {
                    var url = $(this).attr('data-url') + '/' + $(this).val();
                    var $request = new RequestManager.Ajax();
                    var This = $(this);
                    $.get(url).done(function (response) {
                        var variant = This.closest('tr').find('.variant');
                        variant.empty().append(response);
                    })
                });

                $(document).on('click', '.remove-row', function (e) {
                    if ($container.find('tr').length > 1) {
                        if (confirm("Are you sure you want to remove this varinat?")) {
                            $(this).closest('tr').remove();
                        }
                    }
                })

            });
        })(jQuery, window);
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>