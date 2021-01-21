<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <title>Moretti Milano CRM | Login</title>

    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext"
          rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/londinium-theme.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/styles.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/icons.css')); ?>">

    <script src="<?php echo e(asset('assets/js/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/jquery/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/forms/uniform.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/forms/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/forms/inputmask.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/forms/autosize.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/forms/inputlimit.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/forms/listbox.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/forms/multiselect.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/forms/validate.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/forms/tags.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/forms/switch.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/forms/wysihtml5/wysihtml5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/forms/wysihtml5/toolbar.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/interface/daterangepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/interface/fancybox.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/interface/moment.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/interface/jgrowl.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/application.js')); ?>"></script>

</head>

<body class="full-width page-condensed" style="background: #3A4B55">
<div class="login-wrapper">
    <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger">
            <?php foreach($errors->all() as $error): ?>
                <?php echo e($error); ?>

                <br/>
            <?php endforeach; ?>
        </div>
        <br>
    <?php endif; ?>

    <form method="post" action="<?php echo e(url('/auth/login')); ?>" id="loginForm" role="form">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        <div class="well">
            <div class="thumbnail logo">
                <div style="height:220px;">
                    <img src="<?php echo e(asset('assets/images/logo.png')); ?>">
                </div>
            </div>

            <div class="form-group has-feedback">
                <label>User Name</label>
                <input type="text" class="form-control" name="email" id="email">
                <i class="icon-mail-send form-control-feedback"></i>
            </div>

            <div class="form-group has-feedback">
                <label>Password</label>
                <input type="password" class="form-control" name="password" id="password">
                <i class="icon-lock form-control-feedback"></i>
            </div>

            <div class="row form-actions">
                <div class="col-xs-6">
                    <div class="checkbox checkbox-success">
                        <label>
                           <span><a class="" href="<?php echo e(url('password/reset')); ?>">Forgot Password? </a></span>
                        </label>
                    </div>
                </div>

                <div class="col-xs-6">
                    <!--<a class="" href="<?php echo e(url('password/reset')); ?>">Forgot Password? </a> -->
                    <button type="submit" class="btn btn-success pull-right"><i class="icon-checkmark3"></i> Login</button>
                </div>
            </div>
        </div>

    </form>
</div>

<div class="footer clearfix">
    <div class="pull-center">&copy; Moretti Milano 2016</div>
</div>

</body>
</html>