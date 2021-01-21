<?php \Optimait\Laravel\Helpers\Nav::setSegments(Request::segments()); ?>


<div class="sidebar">
    <div class="sidebar-content">
        <ul class="navigation">
            <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('dashboard')) ? 'active' : ''; ?>">
                <a href="<?php echo URL::to('webpanel/dashboard'); ?>">
                    <span>Dashboard</span>
                    <i class="icon-screen2"></i>
                </a>
            </li>

            <li class="<?php echo Route::getCurrentRoute()->getName() == 'webpanel.orders.create' ? 'active' : ''; ?>">
                <a href="<?php echo e(sysRoute('orders.create')); ?>"><span>Make Orders</span>
                    <i class="icon-cart4"></i>
                </a>
            </li>

            <li class="<?php echo Route::getCurrentRoute()->getName() == 'webpanel.orders.index' ? 'active' : ''; ?>">
                <a href="<?php echo e(sysRoute('orders.index')); ?>"><span>View Orders</span>
                    <i class="icon-cart-plus"></i>
                </a>
            </li>

            <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('invoices')) ? 'active' : ''; ?>">
                <a href="<?php echo e(sysRoute('invoices.index')); ?>"><span>View Invoices</span>
                    <i class="icon-file-check"></i>
                </a>
            </li>

            <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('products-orders')) ? 'active' : ''; ?>">
                             <a href="<?php echo e(sysUrl('products-orders')); ?>"><span>Stock Status</span>
                          <i class="icon-database2"></i>
                             </a>
                         </li>

            <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('refunds')) ? 'active' : ''; ?>">
                <a href="<?php echo e(sysUrl('refunds')); ?>"><span>Refunds</span>
                    <i class="icon-briefcase"></i>
                </a>
            </li>

            <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('creditnotes')) ? 'active' : ''; ?>">
                <a href="<?php echo e(sysRoute('creditnotes.index')); ?>"><span>Kreditnota</span>
                    <i class="icon-tab"></i>
                </a>
            </li>

            <?php if(auth()->user()->isSales() || auth()->user()->isAdmin()): ?>
                <!--
                <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('withdraws')) ? 'active' : ''; ?>">
                    <a href="<?php echo e(sysRoute('withdraws.index')); ?>"><span>Withdrawals</span>
                        <i class="icon-signup"></i>
                    </a>
                </li>
                -->
                <li class="<?php echo isAction('Admin\InvoicesController@getCommissions') ? 'active' : ''; ?>">
                    <a href="<?php echo e(sysUrl('commissions')); ?>"><span>Commission</span>
                        <i class="icon-signup"></i>
                    </a>

                </li>
            <?php endif; ?>

            <?php if(auth()->user()->isSales()): ?>
                <!--
                <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('charts')) ? 'active' : ''; ?>">
                    <a href="<?php echo e(sysUrl('charts/purchase')); ?>"><span>Purchase Stats</span>
                        <i class="icon-stats"></i>
                    </a>
                </li>
                -->

                <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('users')) ? 'active' : ''; ?>">
                    <a href="<?php echo e(route('webpanel.users.index')); ?>"><span>Manage Client</span>
                        <i class="icon-users2"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(auth()->user()->isAdmin()): ?>
                <li>
                    <a href="#"><span>Admin Tools</span> <i class="icon-plus"></i></a>
                    <ul>

                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('products')) ? 'active' : ''; ?>">
                            <a href="<?php echo e(sysRoute('products.index')); ?>">Inventory/Stock</a>
                        </li>

                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('emails')) ? 'active' : ''; ?>">
                            <a href="<?php echo e(sysUrl('emails')); ?>">Email Template</a>
                        </li>

                        
                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('factoryorders')) ? 'active' : ''; ?>">
                            <a href="<?php echo e(sysRoute('factoryorders.index')); ?>">Factory Orders</a>
                        </li>

                        <!--
                         <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('clients')) ? 'active' : ''; ?>">
                            <a href="<?php echo e(sysUrl('stats/clients')); ?>">Top Dashboard</a>
                        </li>
                         -->

                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('sales')) ? 'active' : ''; ?>">
                            <a href="<?php echo e(sysUrl('stats/sales')); ?>?type=variant">Top Selling Bags</a>
                        </li>

                        <!--

                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('charts')) ? 'active' : ''; ?>">
                            <a href="<?php echo e(sysUrl('charts/sales')); ?>">Sales/Profit Stats</a>
                        </li>
                           -->
                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('memo')) ? 'active' : ''; ?>">
                            <a href="<?php echo e(sysUrl('memo')); ?>">Memo</a>
                        </li>
                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('budget-sales')) ? 'active' : ''; ?>">
                            <a href="<?php echo e(sysUrl('stats/budget-sales')); ?>">Budget/Sales</a>
                        </li>
                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('currencies')) ? 'active' : ''; ?>">
                            <a href="<?php echo e(sysRoute('currencies.index')); ?>">Manage Currency</a>
                        </li>
                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('users')) ? 'active' : ''; ?>">
                            <a href="<?php echo e(route('webpanel.users.index')); ?>">Manage Users</a>
                        </li>
                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('users')) ? 'active' : ''; ?>">
                            <a href="http://www.morettimilano.com/reports/invoicereport.php" target="_blank">Invoice Report</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
             <!-- new changes -->
             <?php if(auth()->user()->isAdmin()): ?>

             <?php else: ?>
            <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('contact')) ? 'active' : ''; ?>">
                <a href="<?php echo e(sysUrl('contact')); ?>"><span>Contact Us</span>
                    <i class="icon-briefcase"></i>
                </a>
            </li>
            <?php endif; ?>

             <?php if(auth()->user()->isAdmin()): ?>
             <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('user-info')) ? 'active' : ''; ?>">
                <a href="<?php echo e(sysUrl('user-info')); ?>"><span>User Info</span>
                    <i class="icon-user"></i>
                </a>
            </li>
             <?php endif; ?>
            <!-- new changes -->

        </ul>
    </div>
</div>