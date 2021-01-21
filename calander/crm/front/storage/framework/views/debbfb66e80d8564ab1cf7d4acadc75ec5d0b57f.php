<?php $__env->startSection('title'); ?>
The Latest in Powerful 100% Itlian Leather Handbags |Moretti Milano
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php error_reporting(0);?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- banner -->
    <div class="banner">
        <div class="container">
            <div class="banner-info animated wow zoomIn" data-wow-delay=".5s">
              <!--  <h3>Free Online Shopping</h3>-->
                <!--<h4>Up to <span>50% <i>Off/-</i></span></h4>-->
                <div class="wmuSlider example1">
                    <div class="wmuSliderWrapper">
                        <article style="position: absolute; width: 100%; opacity: 0;"> 
                            <div class="banner-wrap">
                                <div class="banner-info1" style="background: rgba(0, 0, 0, 0.2);">
                                    <p>Luxury Leather Handbags</p>
                                    <p>Womens, Mens & Accessories</p>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                    <script src="<?php echo e(Request::root()); ?>/public/front/js/jquery.wmuSlider.js"></script> 
                    <script>
                        $('.example1').wmuSlider();         
                    </script> 
            </div>
        </div>
    </div>
 
    <div class="new-collections">
        <div class="container">
            <h3 class="animated wow zoomIn" data-wow-delay=".5s">New Collections</h3>
           <!-- <p class="est animated wow zoomIn" data-wow-delay=".5s">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
                deserunt mollit anim id est laborum.</p>-->
            <div class="new-collections-grids">
                <!-- start loop -->
                <?php $i=1; ?>
                <?php foreach($products as $product): ?>
                   
                <?php
               // echo $i;
                $folder= $product['photos'][0]['media']['folder'];
                $fileName= $product['photos'][0]['media']['filename'];
                //echo '<pre>';print_r($product['photos'][0]['media']['folder']);die;

                ?>
                   
                <div class="col-md-3 new-collections-grid">
                     
                    <div class="new-collections-grid1 animated wow slideInUp" data-wow-delay=".5s">
                        <div class="new-collections-grid1-image" style="height: 200px !important;">
                            <a href="<?php echo e(url('/single/')); ?>/<?php echo e(encryptIt($product->id)); ?>" class="product-image"><img src="<?php echo e(IMGPATH); ?>/public/<?php echo e($folder.$fileName); ?>" alt=" " class="img-responsive"  onerror="this.onerror=null;this.src='<?php echo e(Request::root()); ?>/public/front/images/no_image.jpg'"/></a>
                            <div class="new-collections-grid1-image-pos">
                                <a href="<?php echo e(url('/single/')); ?>/<?php echo e(encryptIt($product->id)); ?>">Quick View</a>
                            </div>
                            <div class="new-collections-grid1-right">
                                <div class="rating">
                                    <!-- <div class="rating-left">
                                        <img src="<?php echo e(Request::root()); ?>/public/front/images/2.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="<?php echo e(Request::root()); ?>/public/front/images/2.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="<?php echo e(Request::root()); ?>/public/front/images/1.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="<?php echo e(Request::root()); ?>/public/front/images/1.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="<?php echo e(Request::root()); ?>/public/front/images/1.png" alt=" " class="img-responsive" />
                                    </div> -->
                                    <div class="clearfix"> </div>
                                </div>
                            </div>
                        </div>
                        <span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
						<span class="fa fa-star checked"></span>
                        <h4><a href="<?php echo e(url('/single/')); ?>/<?php echo e(encryptIt($product->id)); ?>"><?php echo e($product->name); ?></a></h4>
                        <!-- <p>Vel illum qui dolorem eum fugiat.</p> -->
                        <div class="new-collections-grid1-left simpleCart_shelfItem">
                            <p><!-- <i>$280</i> --> <span class="item_price"><?php if($product->web_shop_price !=0): ?>
                             <?php echo e(currency($product->web_shop_price)); ?>

                        <?php else: ?>
                            <?php echo e(currency($product->price)); ?>

                        <?php endif; ?></span><a class="item_add" href="javascript:;" data-toggle="modal" data-target="#myModal" data="<?php echo e($product->name); ?>" data-id="<?php echo e(encryptIt($product->id)); ?>">add to cart </a></p>
                        </div>
                    </div>
                    
                </div>
                 

                
                <?php $i++; ?>
                     
                <?php endforeach; ?>


            </div>

        </div>
        <center>
            <div class="pagination">
               <a href="<?php echo e(url('/products')); ?>" class="btn btn-success">Show All Product</a>
            </div>
            <?php  //echo count($products);?>
            <?php if(count($products)==0): ?>
            <p style="color:red">No Record Found!</p>
            <?php endif; ?>
            </center>

    </div>
<style type="text/css">
    .col-md-3.new-collections-grid {

    padding-top: 10px;
    }
    .color-box.active, .color-box:hover {
-webkit-transform: scale(1.5);
-moz-transform: scale(1.5);
-ms-transform: scale(1.5);
-o-transform: scale(1.5);
transform: scale(1.5);
}

.banner-bottom-grid-left1-pos p {
    /* color: red; */
    background-color: rgba(0, 0, 0, 0.3);
     
}
	.checked {
  color: green;
}
span.item_price {
    font-size: 15px;
}
    </style>
 
    <div class="collections-bottom" style="display:none;">
        <div class="container">
            <div class="collections-bottom-grids">
                <div class="collections-bottom-grid animated wow slideInLeft" data-wow-delay=".5s">
                    <h3><span>Luxury Leather Handbags</span><span>Womens, Mens & Accessoriess</span></h3>
                </div>
            </div>
            <!-- <div class="newsletter animated wow slideInUp" data-wow-delay=".5s">
                <h3>Newsletter</h3>
                <p>Join us now to get all news and special offers.</p>
                <form>
                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                    <input type="email" value="Enter your email address" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Enter your email address';}" required="">
                    <input type="submit" value="Join Us" >
                </form>
            </div> -->
        </div>
    </div>
<!-- //collections-bottom -->
<!-- footer -->
<div class="container">
  
  <!-- Trigger the modal with a button -->
  <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Product Info</h4>
        </div>
        <div class="modal-body">
            <form class="ajaxForm form-horizontal" method="post" enctype="multipart/form-data"
              action="<?php echo url('/add-to-cart'); ?>"
              role="form" data-result-container="#notificationArea">
              <input type="hidden" name="id" value="" class="product_id">
              <input type="hidden" name="variant_id" value="" class="variant_id">
            <div class="product-info">
            
            </div>
            <br>
            <div class="product-info2">
            <label>Enter Qty</label>
            <input class="form-control newQty" name="qty" value="1" pattern="[0-9]+" max="2">
            <p class="messageQty"></p>
            </div>
            <br>
            <div class="button">
                <button type="button" class="btn btn-success addtocart">ADD TO CART</button>
            </div>
            </form>

            <span class="help-block" id="stock-label"></span>
            <input type="hidden" class="qty1">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>


<script src="//cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
<script>
    $(document).ready(function(){
            $('.addtocart').click(function(){
                var variant_id= $('.variant_id').val();
                var productQty= $('.qty1').val();
                var newQty= $('.newQty').val();
                // alert(productQty);
                // alert(newQty);
                 
                if(variant_id==""){
                    alert('Please choose Color');
                    return false;
                }else if(parseInt(newQty) > parseInt(productQty) ){
                    $('.messageQty').html('Entered Qty Exceeds Available Qty').css('color','red');
                    
                    return false;

                }else{
                    $('.messageQty').html('');
                    //alert('sd');
                   $('.ajaxForm').submit();
                }
            });



            $('.item_add').click(function(){
            var name= $(this).attr('data');
            var productId= $(this).attr('data-id');
            $('.product_id').val(productId);
            $.ajax({
            url:"<?php echo e(url('/product-info')); ?>",
            method:'post',
            data:{'_token':"<?php echo e(csrf_token()); ?>",'keyword':name},
            success:function(ress){
                //alert(ress);
                $('.product-info').html(ress);
            }
            });
        });
    });
</script>
<script>
       /* $(document).on('click',".color-box", function (e) {
                     
                    var Qty= $(this).attr('data-qty');
                    


                    var stockStatus= $(this).attr('data-stock-label');
                    if(stockStatus=='Out Of Stock'){
                        $('.addtocart').prop('disabled',true)
                     }else{
                         $('.addtocart').prop('disabled',false)
                     }
                    $("[name=variant_id]").val($(this).attr('data-id'));
                    $("#stock-label").text($(this).attr('data-stock-label')+' ('+Qty+')');
                    $(".qty1").val(Qty);
                    $(".color-box").removeClass('active');
                    $(this).addClass('active');
                    return false;
                });
            */
            $(document).on('change',".color-box1", function (e) {
                     
                    var Qty= $('option:selected',this).attr('data-qty');
                    


                    var stockStatus= $('option:selected',this).attr('data-stock-label');
                    if(stockStatus=='Out Of Stock'){
                        $('.addtocart').hide();
                     }else{
                         $('.addtocart').show();
                     }
                    $("[name=variant_id]").val($('option:selected',this).attr('data-id'));
                    $("#stock-label").text($('option:selected',this).attr('data-stock-label')+' ('+Qty+')');
                    $(".qty1").val(Qty);
                    $(".color-box").removeClass('active');
                    $(this).addClass('active');
                    return false;
                });
        
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.front-layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>