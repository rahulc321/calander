 <?php $i = 1; ?>
<?php foreach($users as $user): ?>
    <tr class="deleteBox">
        <td>
            <?php echo e($user->full_name); ?>

        </td>

        <td width="15%">
            <?php if($user->isCustomer()): ?>
                <?php if($user->hasOrderedInMonths()): ?>
                <a href="<?php echo e(sysUrl('users/message-inactive/'.encryptIt($user->id))); ?>"
                       data-id="<?php echo e(encryptIt($user->id)); ?>"
                       class="inactive-user modalFetcher"
                       data-target=".remoteModal">
                    <div class="Greencircle" style="float: left; margin-right: 5px"></div>
                <?php else: ?>
                    <a href="<?php echo e(sysUrl('users/message-inactive/'.encryptIt($user->id))); ?>"
                       data-id="<?php echo e(encryptIt($user->id)); ?>"
                       class="inactive-user modalFetcher"
                       data-target=".remoteModal">
                        <div class="Redcircle" style="float: left;margin-right: 5px"></div>
                    </a>
                <?php endif; ?>
                <br>Last Login: <?php echo e(@$user->last_login_at); ?>

                <br>Login Count: <?php echo e(@$user->login_count); ?>

                <br>
            <?php endif; ?>
            <?php if($user->isCustomer()): ?>
                <br/>
                Debitor nr: <?php echo e($user->debitor_number); ?>

            <?php endif; ?>

                <?php if(auth()->user()->isAdmin()): ?>
                   Password: <?php echo e($user->password_text); ?>

                <?php endif; ?>
        </td>
        <td>
            <?php echo e($user->city); ?>

        </td>
        <td>
            <a href="mailto:<?php echo e($user->email); ?>"><?php echo e($user->email); ?></a>
        </td>

        <td><?php echo e($user->phone); ?></td>

        <td><?php echo e(@$user->userType->title); ?></td>
        <?php if(auth()->user()->isAdmin()): ?>
            <?php if($user->isCustomer()): ?>
                <td>
                    <?php if($user->created_by == auth()->user()->id): ?>
                        <label class="label label-info">Administrator</label>
                    <?php else: ?>
                        <label class="label label-info"><?php echo e($user->creator ? $user->creator->fullName() : ''); ?></label>
                    <?php endif; ?>
                </td>
            <?php else: ?>
                <td></td>
            <?php endif; ?>
        <?php endif; ?>
        <td><?php echo e($user->commission > 0 ? $user->commission.' %' : ''); ?></td>
        <td>
            <?php echo e($user->createdDate('d/m/Y')); ?>

        </td>
        <td width="10%">
            <?php if($user->isSales()): ?>
                <a href="<?php echo e(sysUrl('users/budget-planning/'.encryptIt($user->id))); ?>" title="Budget Planning"><i
                            class="icon-calendar2"></i> </a>
            <?php endif; ?>
            <a title="Edit User"
               href="<?php echo URL::route('webpanel.users.edit', array('id' => encrypt($user->id))); ?>"><i
                        class="icon-pencil3"></i>
            </a>
            <a title="Reset Password"
               href="<?php echo url('webpanel/users/reset-password/' . encrypt($user->id)); ?>"><i
                        class="icon-new-tab2"></i></a>
                        
            <a title="Add Wallet Amount"
               href="http://www.morettimilano.com/wallet/wallet.php?id=<? echo $user->id;?>" target="_blank"><i
                        class="icon-new-tab2" ></i></a>
                        
            <a title="Delete User"
               href="#"
               class="ajaxdelete"
               data-id="<?php echo $user->id; ?>"
               data-url="<?php echo sysUrl('users/delete/' . encrypt($user->id)); ?>"
               data-token="<?php echo urlencode(md5($user->id)); ?>"><i class="icon-remove2"></i>
            </a>
        </td>
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>