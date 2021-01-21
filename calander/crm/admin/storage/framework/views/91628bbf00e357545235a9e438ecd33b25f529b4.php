<?php $__env->startSection('title'); ?>
Add User
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Add User</h3>
        </div>
    </div>

    <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Add New User</h6>
        </div>
        <div class="panel-body">
            <form class="form-horizontal ajaxForm" method="post"
                  action="<?php echo URL::route('webpanel.users.store'); ?>"
                  role="form" data-result-container="#notificationArea">

                <div class="form-group">
                    <label class="col-sm-2">Full Name:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="full_name" value="<?php echo e(Input::old('full_name')); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Email Address:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="email" value="<?php echo e(Input::old('email')); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Phone:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="phone" value="<?php echo e(Input::old('phone')); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Address:</label>
                    <div class="col-sm-3">
                        <textarea name="address" class="form-control" style="min-height: 80px;"><?php echo e(Input::old('address')); ?></textarea>
                    </div>
                    <label class="col-sm-1">City:</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="city" value="<?php echo e(Input::old('city')); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Country:</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="country" data-selected="<?php echo e(Input::old('country')); ?>">
                            <option value="">Select Country</option>
                            <?php echo OptionsView(\App\Modules\Country::all(), 'name', 'name'); ?>

                        </select>
                    </div>
                    <label class="col-sm-1">Zip Code:</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" name="zipcode" value="<?php echo e(Input::old('zipcode')); ?>">
                    </div>
                </div>


                <div class="form-group">
                    <label class=" col-md-2" for="commission">Vat Number:</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="vat_number" name="vat_number"
                               value="<?php echo e(Input::get('vat_number')); ?>">
                    </div>
                </div>

                <?php if(auth()->user()->isAdmin()): ?>
                    <div class="form-group">
                        <label class=" col-md-2" for="user_type_id">User Type:</label>
                        <div class="col-md-3">
                            <select class="form-control lazySelector" id="user_type_id" name="user_type_id"
                                    data-selected="<?php echo e(Input::get('user_type_id')); ?>">
                                <option value="<?php echo e(\App\Modules\Users\Types\UserType::SALES_PERSON); ?>">Sales Person
                                </option>
                                <option value="<?php echo e(\App\Modules\Users\Types\UserType::CUSTOMER); ?>">Customer</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class=" col-md-2" for="commission">Discount(%):</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="commission" name="commission"
                                   value="<?php echo e(Input::get('commission')); ?>">
                            <p class="help-block">Only applicable for sales person.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="user_type_id" value="<?php echo e(\App\Modules\Users\Types\UserType::CUSTOMER); ?>">
                <?php endif; ?>

                <?php $debitorNumber = \App\User::getNewDebitorValue(); ?>
                <div class="hideable hidden" id="type-<?php echo e(\App\Modules\Users\Types\UserType::CUSTOMER); ?>">
                    <div class="form-group">
                        <label class="col-md-2" for="debitor_number">Debitor Number:</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="debitor_number" disabled
                                   value="<?php echo e($debitorNumber); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2" for="created_by">Assign To (Sales Person):</label>
                        <div class="col-md-3">
                            <select class="form-control lazySelector" id="sales_person_id" name="sales_person_id">
                                <option value="">Select Sales Person</option>
                                <?php echo OptionsView(\App\User::sales()->get(), 'id', function($item){
                                return $item->fullName();
                                }); ?>

                            </select>
                        </div>
                    </div>



                </div>

                <div class="form-group">
                    <label class="col-md-2" for="password">Password:</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="password" name="password" value="<?php echo e(Input::get('password')); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2" for="password_confirmation">Retype Password:</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" value="<?php echo e(Input::get('password_confirmation')); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2" for="currency_id">Currency:</label>
                    <div class="col-md-3">
                        <select class="form-control lazySelector" id="currency_id" name="currency_id">
                            <option value="">Choose Currency</option>
                            <?php echo OptionsView(\App\Modules\Currencies\Currency::all(), 'id', 'name'); ?>

                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2">User Status:</label>
                    <div class="col-sm-8">
                        <label class="radio-inline radio-success">
                            <input type="radio" name="status" value="1" checked class="styled">
                            Active
                        </label>

                        <label class="radio-inline radio-success">
                            <input type="radio" name="status" value="0" class="styled">
                            In-Active
                        </label>
                    </div>
                </div>
                <!-- 23 Aug -->
                        <div class="form-group">
                            <label class="col-md-2">Show On Map:</label>
                            <div class="col-md-8">
                                <label class="radio-inline radio-success">
                                    <input type="radio" name="map_status" value="0"
                                             class="styled" checked>
                                    Hide
                                </label>

                                <label class="radio-inline radio-success">
                                    <input type="radio" name="map_status" value="1"
                                             class="styled">
                                    Show
                                </label>
                            </div>
                        </div>
                        <!-- 23 Aug -->

                <div class="form-group">
                    <label class="col-sm-2">&nbsp;</label>
                    <div class="col-sm-8">
                        <input type="submit" value="Add User" class="btn btn-warning btn-sm submit-btn">
                    </div>
                </div>
            </form>

        </div>
    </div>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

    <script>

        $(function () {
            changeUi();

            $("[name=user_type_id]").change(function (e) {
                changeUi();
            });

        });

        function changeUi() {
            var userType = $("[name=user_type_id]").val();
            $(".hideable").addClass('hidden');
            $("#type-" + userType).removeClass('hidden');
        }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>