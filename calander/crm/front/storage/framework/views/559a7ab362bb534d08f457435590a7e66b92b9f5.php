<?php $__env->startSection('title', $product->name); ?> 
<?php $__env->startSection('description1', $product->seo_description); ?>
<?php $__env->startSection('title1', $product->seo_title); ?>
<?php $__env->startSection('keywords', $product->seo_keywords); ?>
<?php $__env->startSection('content'); ?>
	<!--share icon-->
<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5d70a1dcab6f1000123c7e78&product=inline-share-buttons' async='async'></script>

 <!--share icon-->
<!-- breadcrumbs -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="<?php echo e(url('/')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Product Detail</li>
			</ol>
		</div>
	</div>


<!-- single -->
	<div class="single">
		<div class="container">
			 <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>	
			<div class="col-md-12 single-right">
				<div class="col-md-5 single-right-left animated wow slideInUp" data-wow-delay=".5s">
					<div class="flexslider">
						<ul class="slides">
 
							
						<?php if($product): ?>
                        <?php foreach($product->photos as $photos): ?>
                             <?php 
							$folder= $photos['media']['folder'];
							$fileName= $photos['media']['filename'] 
                             ?>
                              
                             <input type="hidden" id="main_image" value="https://crm.morettimilano.com/public/<?php echo e($folder.$fileName); ?>">
                             <li data-thumb="https://crm.morettimilano.com/public/<?php echo e($folder.$fileName); ?>" class="flex-active-slide">
								<div class="thumb-image"> <img class="main_image" src="https://crm.morettimilano.com/public/<?php echo e($folder.$fileName); ?>" alt="<?php echo e($product->name); ?>" data-imagezoom="true" class="img-responsive" onerror="this.onerror=null;this.src='<?php echo e(Request::root()); ?>/public/front/images/no_image.jpg'"> </div>
							</li>
                        <?php endforeach; ?>
                        <?php endif; ?>                     
                        <?php if($multi_photo): ?>
                          <?php foreach($multi_photo as $value): ?>
                             <li data-thumb="<?php echo e(IMGPATH); ?>/public/webshop_Images/<?php echo e($value->image); ?>">
								<div class="thumb-image"> <img src="<?php echo e(IMGPATH); ?>/public/webshop_Images/<?php echo e($value->image); ?>" alt="<?php echo substr($value->image, 0, strpos($value->image, '.')); ?>" data-imagezoom="true" class="img-responsive" onerror="this.onerror=null;this.src='<?php echo e(Request::root()); ?>/public/front/images/no_image.jpg'"> </div>
							</li>                   
                          <?php endforeach; ?>
                        <?php endif; ?>

                         <?php if(\App\Modules\Products\Variant::where('product_id',$product->id)->get()): ?>
                         <!-- <?php echo e(\App\Modules\Products\Variant::where('product_id',$product->id)->get()); ?> -->
                          <?php foreach(\App\Modules\Products\Variant::where('product_id',$product->id)->get() as $image): ?>
                          <!-- <?php echo e($image->image); ?> -->
                          <?php if(!empty($image->image)): ?>
                             <li data-thumb="<?php echo e(IMGPATH); ?>/public/variant_images/<?php echo e($image->image); ?>" id="<?php echo e($image->id); ?>">
								<div class="thumb-image"> <img src="<?php echo e(IMGPATH); ?>/public/variant_images/<?php echo e($image->image); ?>" alt="<?php echo e($image->image); ?>" data-imagezoom="true" class="img-responsive" onerror="this.onerror=null;this.src='<?php echo e(Request::root()); ?>/public/front/images/no_image.jpg'"> </div>
							</li> 
							<?php endif; ?>                  
                          <?php endforeach; ?>
                        <?php endif; ?>
							
						
							
						</ul>
					</div>
					<!-- flixslider -->
						<script defer src="<?php echo e(Request::root()); ?>/public/front/js/jquery.flexslider.js"></script>
						<link rel="stylesheet" href="<?php echo e(Request::root()); ?>/public/front/css/flexslider.css" type="text/css" media="screen" />
						<script>
						// Can also be used with $(document).ready()
						$(window).load(function() {
						  $('.flexslider').flexslider({
							animation: "slide",
							controlNav: "thumbnails",
							startAt: 0
						  });
						});
						</script>
					<!-- flixslider -->
				</div>
				
				<div class="col-md-7 single-right-left simpleCart_shelfItem animated wow slideInRight" data-wow-delay=".5s">
					<h3><?php echo e($product->name); ?></h3>
					
					<h4><span class="item_price">
					     <?php if($product->web_shop_price !=0): ?>
                             <?php /*currency($product->web_shop_price)*/ ?>
                              €<?php echo e(number_format($product->web_shop_price/euro()->conversion,2)); ?>

                        <?php else: ?>
                            <?php echo e(currency($product->price)); ?>

                        <?php endif; ?>
					    
					    
					   </span></h4>
					<span class="fa fa-star checked"></span>
					<span class="fa fa-star checked"></span>
					<span class="fa fa-star checked"></span>
					<span class="fa fa-star checked"></span>
					<span class="fa fa-star checked"></span>
					<!-- <div class="description">
						<h5><i>Description</i></h5>
						<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore 
							eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.</p>
					</div> -->
				<form class="ajaxForm form-horizontal" method="post" enctype="multipart/form-data"
				action="<?php echo url('/add-cart'); ?>"
				role="form" data-result-container="#notificationArea">
				<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
				<input type="hidden" name="id" value="<?php echo e(encryptIt($product->id)); ?>">
					<div class="color-quality">
						<div class="color-quality-left">
							<h5>Color : </h5>
							<!-- <ul>
								<li><a href="#"><span></span>Red</a></li>
								<li><a href="#" class="brown"><span></span>Yellow</a></li>
								<li><a href="#" class="purple"><span></span>Purple</a></li>
								<li><a href="#" class="gray"><span></span>Violet</a></li>
							</ul> -->
							<input type="hidden" name="variant_id" value="" class="variant_id">
							<?php $variants = $product->variants()->with('color')->get(); 


							?>
                                    <!--<?php if($variants->count() > 0): ?>-->

                                    <!--    <?php foreach($variants as $variant): ?>-->

                                    <!--        <?php if (!$variant->color): continue; endif;?>-->
                                    <!--        <a class="color-box" style="background:<?php echo e(@$variant->color->hex_code); ?>"-->
                                    <!--           data-stock-label="<?php echo e($variant->qty > 0 ? 'In Stock' : 'Out Of Stock'); ?>"-->
                                    <!--           data-id="<?php echo e($variant->id); ?>" title="<?php echo e(@$variant->color->name); ?>" data-qty="<?=$variant->qty?>"></a>-->
                                    <!--    <?php endforeach; ?>-->
                                    <!--<?php endif; ?>-->
                                    
                                    
                                    <?php if($variants->count() > 0): ?>
                                 		<select class="color-box1">
										<option value="" selected="">Choose color</option>
                                        <?php foreach($variants as $variant): ?>

                                            <?php if (!$variant->color): continue; endif;?>
                                           <!--  <a class="color-box" style="background:<?php echo e(@$variant->color->hex_code); ?>"
                                               data-stock-label="<?php echo e($variant->qty > 0 ? 'In Stock' : 'Out Of Stock'); ?>"
                                               data-id="<?php echo e($variant->id); ?>" title="<?php echo e(@$variant->color->name); ?>" data-qty="<?=$variant->qty?>"></a> -->
                                    
                                    
                                               <option variant_id1="<?php if(!empty($variant->image)) {echo $variant->id;}else{echo '';}?>" data-stock-label="<?php echo e($variant->qty > 0 ? 'In Stock' : 'Out Of Stock'); ?>"
                                               data-id="<?php echo e($variant->id); ?>" title="<?php echo e(@$variant->color->name); ?>" 
                                               data-qty="<?=$variant->qty?>" value="" style="background-color: <?php echo e(@$variant->color->hex_code); ?>;color:<?php if($variant->color->name == "Rosa" || $variant->color->name == "Beige" || $variant->color->name =='Silver Metal'){ echo 'black'; }else{ echo 'white'; } ?>;"><?php echo e(@$variant->color->name); ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                    <?php endif; ?>
						</div>
						 
							
						 
						<div class="color-quality-right">
							<h5>Qty :</h5>
							 <input class="form-control newQty" name="qty" value="1" pattern="[0-9]+">
							 <p class="messageQty"></p>

							<input type="hidden" class="qty1">
						</div>
						<div class="clearfix"> </div>
					</div>
				 


                    <a class="item_add btn btn-primary" href="javascript:;" data-toggle="modal" data-target="#stockStatus" data="<?php echo e($product->name); ?>" data-id="<?php echo e(encryptIt($product->id)); ?>">Stock Status</a>
	

					<!-- <div class="occasional">
						<h5>Occasion :</h5>
						<div class="colr ert">
							<label class="radio"><input type="radio" name="radio" checked=""><i></i>Casual Wear</label>
						</div>
						<div class="colr">
							<label class="radio"><input type="radio" name="radio"><i></i>Party Wear</label>
						</div>
						<div class="colr">
							<label class="radio"><input type="radio" name="radio"><i></i>Formal Wear</label>
						</div>
						<div class="clearfix"> </div>
					</div> -->
					<div class="occasion-cart">
						<!-- <a class="item_add" href="#">add to cart </a> -->
						<p class="help-block" id="stock-label"></p>
						<button type="button" class="btn btn-success">Add To Cart</button>
					</div>
				</form>


<style>

	a.color-box {
	display: block;
	float: left;
	width: 20px;
	height: 20px;
	padding: 5px;
	margin-right: 10px;
	}
	.color-box.active, .color-box:hover {
	-webkit-transform: scale(1.5);
	-moz-transform: scale(1.5);
	-ms-transform: scale(1.5);
	-o-transform: scale(1.5);
	transform: scale(1.5);
	}
	.checked {
  color: green;
}
	</style>

					<div class="social">
						<div class="social-left">
							<p>Share On :</p>
						</div>
						<div class="social-right">
							<!--<ul class="social-icons">-->
							<!--	<li><a href="#" class="facebook"></a></li>-->
							<!--	<li><a href="#" class="twitter"></a></li>-->
							<!--	<li><a href="#" class="g"></a></li>-->
							<!--	<li><a href="#" class="instagram"></a></li>-->
							<!--</ul>-->
							<div class="sharethis-inline-share-buttons"></div>
						</div>
						<div class="clearfix"> </div>
					</div>
				</div>
				<div class="clearfix"> </div>
				<div class="bootstrap-tab animated wow slideInUp" data-wow-delay=".5s">
					<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Description</a></li>
							<li role="presentation"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile">Reviews(<?php echo count($reviews)?>)</a></li>
							<!-- <li role="presentation" class="dropdown">
								<a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents">Information <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
									<li><a href="#dropdown1" tabindex="-1" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1">cleanse</a></li>
									<li><a href="#dropdown2" tabindex="-1" role="tab" id="dropdown2-tab" data-toggle="tab" aria-controls="dropdown2">fanny</a></li>
								</ul>
							</li> -->
						</ul>
						<div id="myTabContent" class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active bootstrap-tab-text" id="home" aria-labelledby="home-tab">
								<h5>Product Brief Description</h5>
								<p><?php echo e($product->description); ?></p>
								<strong>Dimensions:</strong> <br/>
                            Length: <?php echo e($product->length); ?> cm <br/>
                            Height: <?php echo e($product->height); ?> cm <br/>
                            Depth: <?php echo e($product->depth); ?> cm <br/>
                            <hr/>
                            Number of Compartments: <?php echo e($product->number_of_compartments); ?> <br/>
                            Number of Pockets: <?php echo e($product->number_of_pockets); ?> <br/>
								  
							</div>

							<div role="tabpanel" class="tab-pane fade bootstrap-tab-text" id="profile" aria-labelledby="profile-tab">
								<div class="bootstrap-tab-text-grids">
									<div class="bootstrap-tab-text-grid">
										
										<?php foreach($reviews as $review): ?>
										<?php
										$star1= "";
										$star2= "";
										$star3= "";
										$star4= "";
										$star5= "";
										?>
										<div class="bootstrap-tab-text-grid-left">
											<img alt="avatar" src="https://secure.gravatar.com/avatar/e84d2b650819c6e3704dea7fd2f4a472?s=60&amp;d=mm&amp;r=g" srcset="https://secure.gravatar.com/avatar/e84d2b650819c6e3704dea7fd2f4a472?s=120&amp;d=mm&amp;r=g 2x" class="avatar avatar-60 photo" height="60" width="60" style="border-radius: 89px;">
										</div>
										<br>
										<div class="bootstrap-tab-text-grid-right">
											
											<ul>
											
												<li><?php echo e($review->userName); ?></li>
												<?php
												//echo $review->star;
												if($review->star==1){
													$star1= "checked";
												} 
												if($review->star==2){
													$star1= "checked";
													$star2= "checked";
												}
												if($review->star==3){
													$star1= "checked";
													$star2= "checked";
													$star3= "checked";
													
												}
												if($review->star==4){
													$star1= "checked";
													$star2= "checked";
													$star3= "checked";
													$star4= "checked";
													
												}
												if($review->star==5){
													$star1= "checked";
													$star2= "checked";
													$star3= "checked";
													$star4= "checked";
													$star5= "checked";
													
												}

												?>
												<span class="fa fa-star <?=$star1?>"></span>
												<span class="fa fa-star <?=$star2?>"></span>
												<span class="fa fa-star <?=$star3?>"></span>
												<span class="fa fa-star <?=$star4?>"></span>
												<span class="fa fa-star <?=$star5?>"></span>
												 
											</ul>
											<p><?php echo e($review->message); ?></p>
										</div>
										<div class="clearfix"> </div>
										<?php endforeach; ?>
										<?php
									$count= count($userReview);

									?>
									</div>
									<?php if($count == 0 && !empty(\Auth::user()->id)): ?>
									<div class="add-review">
										<h4>add a review</h4>
										<form action="<?php echo e(url('/user-rating')); ?>" method="post">
										<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
											<div class="starbox"> </div>
											<div class="rating-value"></div>
											<input type="hidden" name="ratingval" min="1" class="ratingval" value="1">
											<input type="hidden" name="productId" value="<?php echo e($product->id); ?>">
											</br>
											</br>
											 
											 <label>Your review *</label>
											<textarea type="text"   required="" class="form-control" name="review"></textarea>
											<input type="submit" value="Submit Review" >
										</form>
									</div>
									<?php endif; ?>
								</div>
							</div>

							 
							<div role="tabpanel" class="tab-pane fade bootstrap-tab-text" id="dropdown1" aria-labelledby="dropdown1-tab">
								<p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
							</div>
							<div role="tabpanel" class="tab-pane fade bootstrap-tab-text" id="dropdown2" aria-labelledby="dropdown2-tab">
								<p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
 <!--Model-->
 <div class="container">
  
  <!-- Trigger the modal with a button -->
  <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

  <!-- Modal -->
  <div class="modal fade" id="stockStatus" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo e($product->name); ?></h4>
        </div>
        <div class="modal-body">
             <table class="table table-condensed">
    <thead>
      <tr>
        <th>Color</th>
        <th>Stock Available</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    	 <?php foreach($variants as $variant): ?>

      <tr>
        <td><?php echo e(@$variant->color->name); ?><a class="color-box" style="background:<?php echo e(@$variant->color->hex_code); ?>"
                                               data-stock-label="<?php echo e($variant->qty > 0 ? 'In Stock' : 'Out Of Stock'); ?>"
                                               data-id="<?php echo e($variant->id); ?>" title="<?php echo e(@$variant->color->name); ?>" data-qty="<?=$variant->qty?>"></a></td>
        <td><?php echo e($variant->qty); ?></td>
        <td>
        	<?php if($variant->qty > 0): ?>
        	<button class="in_stck">In Stock</button>
        	<?php else: ?>
        	<button class="out_stck">Out Of Stock</button>
        	<?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

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
 <!--Model-->
	<script src="<?php echo e(Request::root()); ?>/public/front/js/imagezoom.js"></script>
<link rel="stylesheet" href="https://rawgit.com/sabberworm/jStarbox/master/css/jstarbox.css">
<div class="block">
     
</div>
 
<style type="text/css">
    .block {
    display: block;
    clear: both;
}
.starbox {
    float: left;
}
.rating-value {
    float: left;
    margin: -10px 0 0 20px;
}
</style>
 
<script src="//rawgit.com/sabberworm/jStarbox/master/jstarbox.js"></script>
<script type="text/javascript">
    $(function() {
    	// var ln = $('.flexslider ul li').length;
    	// alert(ln);
        $('.starbox').each(function() {
            var starbox = $(this);
            starbox.starbox({
                average: 0.2,
                changeable: true,
                ghosting: true,
                autoUpdateAverage: true,
            }).bind('starbox-value-moved', function(event, value) {
                 
                $('.ratingval').val(value*5);

            });
        });
    });
</script>
	<script>
        (function ($, window, document, undefined) {
            $(function () {
            	$('.btn-success').click(function(){
                var variant_id= $('.variant_id').val();
                var productQty= $('.qty1').val();
                var newQty= $('.newQty').val();
                 
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




                // $(".color-box").on('click', function (e) {
                // 	var Qty= $(this).attr('data-qty');

                // 	var stockStatus= $(this).attr('data-stock-label');
                //     if(stockStatus=='Out Of Stock'){
                //         $('.btn-success').prop('disabled',true)
                //      }else{
                //          $('.btn-success').prop('disabled',false)
                //      }
                //     $("[name=variant_id]").val($(this).attr('data-id'));
                //      $("#stock-label").text($(this).attr('data-stock-label')+' ('+Qty+')');
                //      $(".qty1").val(Qty);
                //     $(".color-box").removeClass('active');
                //     $(this).addClass('active');
                //     return false;
                // });
                $(".color-box1").on('change', function (e) {
                	var vid= $('option:selected',this).attr('variant_id1');
                	var index = $('.slides li').index($('#'+vid));
                	if(index == -1){
                	$('.flexslider').data("flexslider").flexAnimate(0);
                	// $('.flexslider').data("flexslider").play();
                	} else{
                	$('.flexslider').data("flexslider").flexAnimate(index-1);
                	// $('.flexslider').data("flexslider").pause();
                	}
                	// index = 1;
                	// alert(index);
       //               $('.flexslider').flexslider({
							// animation: "slide",
							// controlNav: "thumbnails",
							// startAt: 0
						 //  });
                    // $('.variantId').each(function(){
                    // var variant = $(this).attr('data-variant');
                                       
                     // if(variant == vid){
                       // if($('#'+vid).siblings().hasClass('flex-active-slide')){
                       //   $('#'+vid).siblings().removeClass('flex-active-slide');
                       //   $('#'+vid).addClass('flex-active-slide');
                       //   // $('.flexslider ul').css('width': '1200%', 'transition-duration': '0s', 'transform': 'translate3d(-423px, 0px, 0px)');
                       // }                    	
                     // }
                    // });
                	var Qty= $('option:selected',this).attr('data-qty');
                	
                	// alert(url);
                    
                	var stockStatus= $('option:selected',this).attr('data-stock-label');
                	if(stockStatus == undefined){
                		$("#stock-label").text("Please select a color!!").css({"color": "red", "font-style": "oblique"});
                		$('.btn-success').hide();
                	}
                    else {
                    if(stockStatus=='Out Of Stock'){
                        $('.btn-success').hide();
                     }else{
                         $('.btn-success').show();
                     }
                    $("[name=variant_id]").val($('option:selected',this).attr('data-id'));
                     $("#stock-label").text($('option:selected',this).attr('data-stock-label')+' ('+Qty+')').css({"color": "#737373", "font-style": "normal"});
                     $(".qty1").val(Qty);
                    $(".color-box").removeClass('active');
                    $(this).addClass('active');
                    return false;
                    }
                });
            });
        })(jQuery, window, document);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.front-layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>