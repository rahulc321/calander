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
                <a href="{{ sysRoute('orders.create') }}"><span>Make Orders</span>
                    <i class="icon-cart4"></i>
                </a>
            </li>

            <li class="<?php echo Route::getCurrentRoute()->getName() == 'webpanel.orders.index' ? 'active' : ''; ?>">
                <a href="{{ sysRoute('orders.index') }}"><span>View Orders</span>
                    <i class="icon-cart-plus"></i>
                </a>
            </li>

            <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('invoices')) ? 'active' : ''; ?>">
                <a href="{{ sysRoute('invoices.index') }}"><span>View Invoices</span>
                    <i class="icon-file-check"></i>
                </a>
            </li>

            <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('products-orders')) ? 'active' : ''; ?>">
                             <a href="{{ sysUrl('products-orders') }}"><span>Stock Status</span>
                          <i class="icon-database2"></i>
                             </a>
                         </li>

            <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('refunds')) ? 'active' : ''; ?>">
                <a href="{{ sysUrl('refunds') }}"><span>Refunds</span>
                    <i class="icon-briefcase"></i>
                </a>
            </li>

            <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('creditnotes')) ? 'active' : ''; ?>">
                <a href="{{ sysRoute('creditnotes.index') }}"><span>Kreditnota</span>
                    <i class="icon-tab"></i>
                </a>
            </li>

            @if(auth()->user()->isSales() || auth()->user()->isAdmin())
                <!--
                <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('withdraws')) ? 'active' : ''; ?>">
                    <a href="{{ sysRoute('withdraws.index') }}"><span>Withdrawals</span>
                        <i class="icon-signup"></i>
                    </a>
                </li>
                -->
                <li class="<?php echo isAction('Admin\InvoicesController@getCommissions') ? 'active' : ''; ?>">
                    <a href="{{ sysUrl('commissions') }}"><span>Commission</span>
                        <i class="icon-signup"></i>
                    </a>

                </li>
            @endif

            @if(auth()->user()->isSales())
                <!--
                <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('charts')) ? 'active' : ''; ?>">
                    <a href="{{ sysUrl('charts/purchase') }}"><span>Purchase Stats</span>
                        <i class="icon-stats"></i>
                    </a>
                </li>
                -->

                <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('users')) ? 'active' : ''; ?>">
                    <a href="{{ route('webpanel.users.index') }}"><span>Manage Client</span>
                        <i class="icon-users2"></i>
                    </a>
                </li>
            @endif

            @if(auth()->user()->isAdmin())
                <li>
                    <a href="#"><span>Admin Tools</span> <i class="icon-plus"></i></a>
                    <ul>

                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('products')) ? 'active' : ''; ?>">
                            <a href="{{ sysRoute('products.index') }}">Inventory/Stock</a>
                        </li>

                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('emails')) ? 'active' : ''; ?>">
                            <a href="{{ sysUrl('emails') }}">Email Template</a>
                        </li>

                        
                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('factoryorders')) ? 'active' : ''; ?>">
                            <a href="{{ sysRoute('factoryorders.index') }}">Factory Orders</a>
                        </li>

                        <!--
                         <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('clients')) ? 'active' : ''; ?>">
                            <a href="{{ sysUrl('stats/clients') }}">Top Dashboard</a>
                        </li>
                         -->

                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('sales')) ? 'active' : ''; ?>">
                            <a href="{{ sysUrl('stats/sales') }}?type=variant">Top Selling Bags</a>
                        </li>

                        <!--

                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('charts')) ? 'active' : ''; ?>">
                            <a href="{{ sysUrl('charts/sales') }}">Sales/Profit Stats</a>
                        </li>
                           -->
                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('memo')) ? 'active' : ''; ?>">
                            <a href="{{ sysUrl('memo') }}">Memo</a>
                        </li>
                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('budget-sales')) ? 'active' : ''; ?>">
                            <a href="{{ sysUrl('stats/budget-sales') }}">Budget/Sales</a>
                        </li>
                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('currencies')) ? 'active' : ''; ?>">
                            <a href="{{ sysRoute('currencies.index') }}">Manage Currency</a>
                        </li>
                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('users')) ? 'active' : ''; ?>">
                            <a href="{{ route('webpanel.users.index') }}">Manage Users</a>
                        </li>
                        <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('users')) ? 'active' : ''; ?>">
                            <a href="http://www.morettimilano.com/reports/invoicereport.php" target="_blank">Invoice Report</a>
                        </li>
                    </ul>
                </li>
            @endif
             <!-- new changes -->
             @if(auth()->user()->isAdmin())

             @else
            <li class="<?php echo \Optimait\Laravel\Helpers\Nav::isActiveMultiple(array('contact')) ? 'active' : ''; ?>">
                <a href="{{ sysUrl('contact') }}"><span>Contact Us</span>
                    <i class="icon-briefcase"></i>
                </a>
            </li>
            @endif
            <!-- new changes -->

        </ul>
    </div>
</div>