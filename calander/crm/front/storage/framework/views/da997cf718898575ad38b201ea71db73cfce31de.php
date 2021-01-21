<?php $__env->startSection('title'); ?>
    Budget
    @parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3><?php echo e($user->full_name); ?> Budget</h3>
        </div>
    </div>

    <?php
    $budgets = [];
    $totalBudgets = 0;
    $totalCurrentBudget = 0;
    foreach ($user->budgets as $budget) {
        $budgets[$budget->month] = $budget->budget;
    }
    $currentSales = 0;
    $currentYear = date("Y");
    $currentMonth = date("m");
    $chartData = [
        'categories' => [],
        'sales' => [],
        'budget' => []
    ];
    ?>

    <div class="row">
        <div class="col-lg-12">
            <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Budget/Sales</h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>MONTH</th>
                            <th>
                                <?php echo implode('</th><th>', monthsArray()); ?>

                            </th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>BUDGET (DKK)</th>
                            <?php foreach(monthsArray() as $m => $month): ?>
                                <td><?php echo e(@$budgets[$m]); ?></td>
                                <?php
                                $totalBudgets += $budgets[$m];
                                if ($m <= $currentMonth) {
                                    $totalCurrentBudget += isset($budgets[$m]) ? $budgets[$m] : 0;
                                }
                                ?>
                            <?php endforeach; ?>
                            <th><?php echo e($totalCurrentBudget); ?></th>
                        </tr>
                        <tr>
                            <th>SALES (DKK)</th>
                            <?php foreach(monthsArray() as $m => $month): ?>
                                <?php if($m <= $currentMonth): ?>
                                    <?php
                                    $sales = getTotalFromOrders(\App\Modules\Orders\Order::whereIn('created_by', $user->myCustomers->pluck('id')->toArray())
                                        ->whereRaw(DB::raw("YEAR(created_at) = " . $currentYear))
                                        ->whereRaw(DB::raw("MONTH(created_at) = " . $m))
                                        ->whereIn('status', [\App\Modules\Orders\Order::STATUS_PAID, \App\Modules\Orders\Order::STATUS_SHIPPED])
                                        ->get());
                                    $chartData['categories'][] = $month;
                                    $chartData['sales'][] = (float)$sales;
                                    $chartData['budget'][] = isset($budgets[$m]) ? (float)$budgets[$m] : 0;
                                    $currentSales += $sales;
                                    ?>
                                    <td>
                                        <?php echo e(number_format($sales, 2)); ?>

                                    </td>
                                <?php else: ?>
                                    <td>-</td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <th><?php echo e($currentSales); ?></th>
                        </tr>
                        <tr>
                            <th>STATUS</th>
                            <?php foreach(monthsArray() as $m => $month): ?>
                                <?php $val = (isset($chartData['sales'][$m - 1]) ? $chartData['sales'][$m - 1] : 0) - (isset($chartData['budget'][$m - 1]) ? $chartData['budget'][$m - 1] : 0);?>
                                <td>
                                    <?php if($val >= 0): ?>
                                        <?php echo isset($chartData['sales'][$m - 1]) ? '<span class="text-success">GOOD</span>' : ''; ?>

                                    <?php else: ?>
                                        <?php echo isset($chartData['sales'][$m - 1]) ? '<span class="text-danger">BAD</span>' : ''; ?>

                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                            <th>
                                <?php echo $currentSales - $totalCurrentBudget > 0 ? '<span class="text-success">GOOD</span>' : '<span class="text-danger">BAD</span>'; ?>

                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Budget & Sales Chart</h3>
                </div>
                <div class="panel-body">
                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Update Your Budget</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="<?php echo e(sysUrl('users/budget-planning/'.encryptIt($user->id))); ?>"
                          class="form-inline">
                        <table class="table">
                            <?php foreach(monthsArray() as $m => $month): ?>
                                <tr>
                                    <td><?php echo e($month); ?></td>
                                    <td>
                                        <input type="text" class="form-control" name="budget[<?php echo e($m); ?>]"
                                               value="<?php echo e(@$budgets[$m]); ?>"
                                               onkeypress="return validateFloatKeyPress(this,event);">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <input type="submit" class="btn btn-primary pull-right" name="save" value="Save">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php event('js.transform', [['chartData' => $chartData]]); ?>

    <script src="<?php echo e(asset('assets/js/highcharts/highcharts.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/highcharts/exporting.js')); ?>"></script>

    <script type="text/javascript">
        console.log(chartData);

        function validateFloatKeyPress(el, evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            var number = el.value.split('.');
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            if (number.length > 1 && charCode == 46) {
                return false;
            }
            var caratPos = getSelectionStart(el);
            var dotPos = el.value.indexOf(".");
            if (caratPos > dotPos && dotPos > -1 && (number[1].length > 1)) {
                return false;
            }
            return true;
        }

        function getSelectionStart(o) {
            if (o.createTextRange) {
                var r = document.selection.createRange().duplicate()
                r.moveEnd('character', o.value.length)
                if (r.text == '') return o.value.length
                return o.value.lastIndexOf(r.text)
            } else return o.selectionStart
        }

        $(function () {

            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: "<?php echo e($user->full_name); ?> Budget and Sales Chart"
                },
                xAxis: {
                    categories: chartData.categories,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Amount (DKK)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Budget',
                    data: chartData.budget

                }, {
                    name: 'Sales',
                    data: chartData.sales

                }]
            });

        });

    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>