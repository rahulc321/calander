<?php $__env->startSection('title'); ?>
    Factory Order
    @parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Add Factory Orders</h3>
        </div>
    </div>

    <div class="content">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <form method="post" action="<?php echo e(sysRoute('factoryorders.store')); ?>" class="ajaxForm form-horizontal">
            <div class="table-responsive">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="hpanel">
                            <div class="panel-body">
                                <div class="col-md-3">
                                    <label for="">Factory Name:</label>
                                    <div>
                                        <input type="text" class="form-control" name="factory_name" value="<?php echo e(old('factory_name')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Order Number:</label>
                                    <div>
                                        <input type="text" class="form-control" name="OID" value="<?php echo e(old('OID')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Delivery Date:</label>
                                    <div>
                                        <input type="text" class="form-control dp" name="delivery_date"
                                               value="<?php echo e(old('delivery_date')); ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <br/>
                                    <input class="btn btn-warning btn-sm" type="submit" name="save" value="Order">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php foreach($products as $product): ?>
                        <input type="hidden" name="buying_price[<?php echo e($product->id); ?>]" value="<?php echo e($product->price); ?>">
                        <div class="col-md-4">
                            <div class="product-container" style="margin-bottom:50px;">
                                <a href="#" class="btn btn-xs add-row" style="margin-left:10px;"><i class="icon-plus-circle"></i> </a>

                                <label><?php echo e($product->name); ?></label>
                                <table class="table" style="width:375px;">
                                    <tbody class="variant-container">
                                    <tr>
                                        <td>
                                            <select class="form-control lazySelector blank"
                                                    name="variants[<?php echo e($product->id); ?>][]">
                                                <option value="">Select Variant</option>
                                                <?php echo OptionsView($product->variants()->with('color')->get(), 'id', function($item){
                                                    return @$item->color->name;
                                                }); ?>

                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control blank" placeholder="Quantity"
                                                   name="qty[<?php echo e($product->id); ?>][]" value=""
                                                   onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                        </td>
                                        <td>
                                            <a class="remove-row text-danger" title="remove"><i class="icon-remove3"></i> </a>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

        </form>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        (function ($, window, undefined) {
            $(function () {


                $(".add-row").click(function (e) {
                    var $container = $(this).closest('.product-container').find('.variant-container');
                    var row = $container.find('tr:last').clone(true);
                    row.find('.blank').val('');
                    $container.append(row);

                    e.preventDefault();
                    return false;
                });


                $(document).on('click', '.remove-row', function (e) {
                    var $container = $(this).closest('.product-container').find('.variant-container');
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