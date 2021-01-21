<?php $__env->startSection('title'); ?>
Edit Kreditnota
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Update Kreditnota</h3>
        </div>
    </div>

    <div class="content">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <form method="post" action="<?php echo e(sysRoute('creditnotes.update', encryptIt($creditNote->id))); ?>"
              class="ajaxForm form-horizontal">
            <input type="hidden" name="_method" value="put">

            <div class="well">
                <div class="form-group">
                    <label class="control-label col-md-2" for="user">Customer:</label>
                    <div class="col-md-5">
                        <?php echo e($creditNote->user ? $creditNote->user->fullName() : ''); ?>

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2" for="note">Note (Memo):</label>
                    <div class="col-md-5">
                        <textarea class="form-control" id="note" name="note"><?php echo e($creditNote->note); ?></textarea>
                    </div>
                </div>
            </div>

            <br/>

            <div class="well">
                <a id="add-row" class="btn btn-primary btn-xs">+ Add</a>

                <table class="table">
                    <thead>
                    <tr>
                        <th style="width:200px;">Product</th>
                        <th style="width: 200px;">Variant</th>
                        <th style="width:100px;">Qty</th>
                    </tr>
                    </thead>
                    <tbody id="credit-container">
                    <?php foreach($creditNote->items as $item): ?>
                        <tr>
                            <td>
                                <select name="product_id[]" class="form-control blank product" required
                                        data-url="<?php echo e(sysUrl('products/variants-ajax')); ?>">
                                    <option value="">Select</option>
                                    <?php echo OptionsView(\App\Modules\Products\Product::all(), 'id', 'name', $item->product_id); ?>

                                </select>
                            </td>
                            <td>
                                <select name="variant_id[]" class="form-control variant empty" required>
                                    <option value="">Choose</option>
                                    <?php echo OptionsView($item->product->variants, 'id', function($i){
                                        return @$i->color->name;
                                    }, $item->variant_id); ?>

                                </select>
                            </td>
                            <td>
                                <input type="number" name="qty[]" class="form-control blank" value="<?php echo e($item->qty); ?>" required>
                            </td>
                            <td>
                                <a class="remove-row btn-xs btn-danger"><i class="icon icon-remove3"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <input type="submit" class="btn btn-primary" name="save" value="Save">
            </div>

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