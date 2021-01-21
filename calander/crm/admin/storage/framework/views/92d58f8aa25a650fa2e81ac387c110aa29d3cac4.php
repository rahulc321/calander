<?php $__env->startSection('title'); ?>
    Product: <?php echo e($product->name); ?>

    @parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<style>
.s-hidden {
    visibility:hidden;
    padding-right:10px;
}
.select {
    cursor:pointer;
    display:inline-block;
    position:relative;
    font:normal 11px/22px Arial, Sans-Serif;
    color:black;
    border:1px solid #ccc;
}
.styledSelect {
    position:absolute;
    top:0;
    right:0;
    bottom:0;
    left:0;
    background-color:white;
    padding:0 10px;
    font-weight:bold;
}
.styledSelect:after {
    content:"";
    width:0;
    height:0;
    border:5px solid transparent;
    border-color:black transparent transparent transparent;
    position:absolute;
    top:9px;
    right:6px;
}
.styledSelect:active, .styledSelect.active {
    background-color:#eee;
}
.options {
    display:none;
    position:absolute;
    top:100%;
    right:0;
    left:0;
    z-index:999;
    margin:0 0;
    padding:0 0;
    list-style:none;
    border:1px solid #ccc;
    background-color:white;
    -webkit-box-shadow:0 1px 2px rgba(0, 0, 0, 0.2);
    -moz-box-shadow:0 1px 2px rgba(0, 0, 0, 0.2);
    box-shadow:0 1px 2px rgba(0, 0, 0, 0.2);
}
.options li {
    padding:0 6px;
    margin:0 0;
    padding:0 10px;
}
.options li:hover {
    background-color:#39f;
    color:white;
}
</style>
<link rel="stylesheet" href="<?php echo e(Request::root()); ?>/selectbox/css/style.css">
  <link rel="stylesheet" href="<?php echo e(Request::root()); ?>/selectbox/css/customoptions.css"> 
  <link rel="stylesheet" id="theme" href="<?php echo e(Request::root()); ?>/selectbox/css/selectric.css">
    <div class="page-header">
        <div class="page-title">
            <h3>Product: <?php echo e($product->name); ?>

                <small>Select required Qty and Process.</small>
            </h3>
        </div>
        <div class="range">
            <?php
            $previousProduct = false;
            $previous = \App\Modules\Products\Product::where('id', '<', $product->id)->max('id');
            if ($previous) {
                $previousProduct = \App\Modules\Products\Product::find($previous);
            }

            // get next user id
            $nextProduct = false;
            $next = \App\Modules\Products\Product::where('id', '>', $product->id)->min('id');
            if ($next) {
                $nextProduct = \App\Modules\Products\Product::find($next);
            }
            ?>
            <?php if($previousProduct): ?>
                <a href="<?php echo e(sysUrl('products/item-for-order/'.encryptIt($previous))); ?>"
                   class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Previous</a>
            <?php endif; ?>

            <?php if($nextProduct): ?>
                <a href="<?php echo e(sysUrl('products/item-for-order/'.encryptIt($next))); ?>"
                   class="btn btn-warning btn-sm">Next <i class="fa fa-arrow-right"></i> </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="content">
        <form class="ajaxForm form-horizontal" method="post" enctype="multipart/form-data"
              action="<?php echo sysUrl('orders/add-to-cart'); ?>"
              role="form" data-result-container="#notificationArea">
            <input type="hidden" name="id" value="<?php echo e(encryptIt($product->id)); ?>">

            <div class="panel">
                <div class="panel-body">
                    <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="row">
                        <div class="col-md-6">
                        <?php $i=1; ?>
                        <?php foreach($product->photos as $k => $photo): ?>
                            <?php if($i==1): ?>
                             <img src="<?php echo e($photo->getFileUrl()); ?>" data-lazy="<?php echo e($photo->getFileUrl()); ?>" style="width:100%;"/>
                            <?php endif; ?>
                        <?php $i++; ?>
                        <?php endforeach; ?>

                        </div>
                        <div class="col-md-6">
                            <strong><?php echo e(currency($product->price)); ?></strong><br>
                            <div class="row">
                                <div class="col-md-3">
                                    <input class="form-control" name="qty" value="1" pattern="[0-9]+">
                                </div>
                                <span class="help-block" id="stock-label"></span>
                            </div>

                            <br/><br/>
                           <strong>Select Colors:</strong><br><br/>

                            <div class="row">
                                <div class="col-md-7">
                                    <input type="hidden" name="variant_id" value="">
                                    <?php $variants = $product->variants()->with('color')->get(); ?>
                                    <select class="color-box1 custom-options">
                                    <option value="" selected >Choose Color</option>
                                    <?php if($variants->count() > 0): ?>
                                        <?php foreach($variants as $variant): ?>
                                            <?php if (!$variant->color): continue; endif;
                                                $colorName= $variant->color->name;

                                            ?>

                                            
                                            <!-- <option value="<?php echo e($variant->id); ?>" data-id="<?php echo e($variant->id); ?>" data-stock-label="<?php echo e($variant->qty > 0 ? 'In Stock' : 'Out Of Stock'); ?>"
                                               data-id="<?php echo e($variant->id); ?>" <?php if($colorName=='Black' || $colorName=='Brown' || $colorName=='Blue Marine' || $colorName=='Bordeaux'){ $txtColor= 'white';}else{ $txtColor='black'; } ?> style="background:<?php echo e(@$variant->color->hex_code); ?>;color:<?php echo e($txtColor); ?>">
                                               <?php echo e(@$variant->color->name); ?>

                                            </option> -->


                                            <option data-id="<?php echo e($variant->id); ?>" data-id="<?php echo e($variant->id); ?>" data-name="<?php echo e(@$variant->color->name); ?>" data-stock-label="<?php echo e($variant->qty > 0 ? 'In Stock' : 'Out Of Stock'); ?>" value="<?php echo e(@$variant->color->hex_code); ?>"><?php echo e(@$variant->color->name); ?></option>

                                        <?php endforeach; ?>
                                    </select>
                                    <?php endif; ?>
                                    
                                       
                            
          
     

                                </div>

                            </div>
                            <br>
                            <div style="padding-left:0px;">
                                <button type="submit" class="btn btn-success">Add To Cart</button>
                            </div>
                            <br/>
                            <strong>Description:</strong><br>
                            <p><?php echo e($product->description); ?></p>
                            <strong>Dimensions:</strong> <br/>
                            Length: <?php echo e($product->length); ?> cm <br/>
                            Height: <?php echo e($product->height); ?> cm <br/>
                            Depth: <?php echo e($product->depth); ?> cm <br/>
                            <hr/>
                            Number of Compartments: <?php echo e($product->number_of_compartments); ?> <br/>
                            Number of Pockets: <?php echo e($product->number_of_pockets); ?> <br/>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
   

   

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<!-- <script src="<?php echo e(Request::root()); ?>/selectbox/js/jquery.selectric.js"></script>
  <script src="<?php echo e(Request::root()); ?>/selectbox/js/demo.js"></script>-->
    <script>
        (function ($, window, document, undefined) {
            $(function () {
               /* $(".color-box1").change(function (e) {
                    //alert();
                    $("[name=variant_id]").val($('option:selected', this).attr('data-id'));
                    $("#stock-label").text($('option:selected', this).attr('data-stock-label'));
                    $(".color-box").removeClass('active');
                    $('option:selected', this).addClass('active');
                    return false;
                });*/
                
                // Iterate over each select element
        $('.color-box1').each(function () {
        
            // Cache the number of options
            var $this = $(this),
                numberOfOptions = $(this).children('option').length;
        
            // Hides the select element
            $this.addClass('s-hidden');
        
            // Wrap the select element in a div
            $this.wrap('<div class="select"></div>');
        
            // Insert a styled div to sit over the top of the hidden select element
            $this.after('<div class="styledSelect"></div>');
        
            // Cache the styled div
            var $styledSelect = $this.next('div.styledSelect');
        
            // Show the first select option in the styled div
            $styledSelect.text($this.children('option').eq(0).text());
        
            // Insert an unordered list after the styled div and also cache the list
            var $list = $('<ul />', {
                'class': 'options'
            }).insertAfter($styledSelect);
        
            // Insert a list item into the unordered list for each select option
            for (var i = 0; i < numberOfOptions; i++) {
                var color = '#000';
                if($this.children('option').eq(i).text() == 'Black' || $this.children('option').eq(i).text()=='Brown' || $this.children('option').eq(i).text()=='Blue Marine' || $this.children('option').eq(i).text()=='Bordeaux') {
                    color = '#fff';
                }
                
                $('<li />', {
                    style: 'background-color: '+ $this.children('option').eq(i).val() + '; color: '+ color,
                    text: $this.children('option').eq(i).text(),
                    rel: $this.children('option').eq(i).attr('data-id'),
                    id: $this.children('option').eq(i).attr('data-stock-label')
                }).appendTo($list);
            }
        
            // Cache the list items
            var $listItems = $list.children('li');
        
            // Show the unordered list when the styled div is clicked (also hides it if the div is clicked again)
            $styledSelect.click(function (e) {
                e.stopPropagation();
                $('div.styledSelect.active').each(function () {
                    $(this).removeClass('active').next('ul.options').hide();
                });
                $(this).toggleClass('active').next('ul.options').toggle();
            });
        
            // Hides the unordered list when a list item is clicked and updates the styled div to show the selected list item
            // Updates the select element to have the value of the equivalent option
            $listItems.click(function (e) {
                e.stopPropagation();
                $styledSelect.text($(this).text()).removeClass('active');
                $this.val($(this).attr('rel'));
                $("[name=variant_id]").val($(this).attr('rel'));
                $("#stock-label").text($(this).attr('id'));
                $list.hide();
                /* alert($this.val()); Uncomment this for demonstration! */
            });
        
            // Hides the unordered list when clicking outside of it
            $(document).click(function () {
                $styledSelect.removeClass('active');
                $list.hide();
            });
        
        });
                
            });
        })(jQuery, window, document);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>