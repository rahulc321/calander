<?php $__env->startSection('title'); ?>
    Budget
    @parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Budget/Sales Analysis
            </h3>
        </div>
    </div>

    <?php
    $selectedCountry = Input::get('country', $countries[0]);
    $budgets = [];
    $totalBudgets = 0;
    $totalCurrentBudget = 0;
    foreach ($salesPersons as $user) {
        foreach ($user->budgets as $budget) {
            $budgets[$budget->month] = $budget->budget;
        }
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

            <div class="panel">
                <div class="panel-heading">
                    <div class="pull-right">
                        <form method="get" class="form-inline">
                            <select class="form-control lazySelector"
                                    id="country" name="country" data-selected="<?php echo e(Input::get('country')); ?>">
                                <?php foreach($countries as $country): ?>
                                    <option value="<?php echo e($country); ?>"><?php echo e($country); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="submit" class="btn btn-primary" name="filter" value="Filter">
                        </form>
                    </div>
                </div>


                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <th>MONTH</th>
                        <th>
                            <?php echo implode('</th><th>', monthsArray()); ?>

                        </th>
                        <th>Total</th>
                        </thead>
                        <tbody>
                        <tr>
                            <th>BUDGET</th>
                            <?php foreach(monthsArray() as $m => $month): ?>
                                <?php
                                $totalBudgets += $budgets[$m];
                                if($m <= $currentMonth){
                                    $totalCurrentBudget += isset($budgets[$m]) ? $budgets[$m] : 0;
                                }
                                ?>
                                <td><?php echo e(@$budgets[$m]); ?></td>
                            <?php endforeach; ?>
                            <th><?php echo e($totalCurrentBudget); ?></th>
                        </tr>
                        <tr>
                            <th>SALES</th>
                            <?php foreach(monthsArray() as $m => $month): ?>
                                <?php if($m <= $currentMonth): ?>
                                    <?php
                                    $sales = getTotalFromOrders(\App\Modules\Orders\Order::whereIn('sales_person_id', $salesPersons->pluck('id')->toArray())
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

                    <?php
                    $sales = getTotalFromOrders(\App\Modules\Orders\Order::whereIn('sales_person_id', $allSalesPerson->pluck('id')->toArray())
                        ->whereRaw(DB::raw("YEAR(created_at) = " . $currentYear))
                        ->whereIn('status', [\App\Modules\Orders\Order::STATUS_PAID, \App\Modules\Orders\Order::STATUS_SHIPPED])
                        ->get());
                    ?>
                    <br/>
                    <strong>Total Sales For All: <?php echo e(currency($sales)); ?></strong>
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
                    text: "<?php echo e($selectedCountry); ?> Budget and Sales Chart"
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