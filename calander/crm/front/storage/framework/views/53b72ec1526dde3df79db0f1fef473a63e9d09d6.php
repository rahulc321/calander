<?php $__env->startSection('title'); ?>
The Latest in Powerful 100% Italian Leather Handbags |Moretti Milano
<?php $__env->stopSection(); ?>
<?php $__env->startSection('description1'); ?>
Buy online Italian genuine leather luxury ladies handbags and men accessories at Moretti Milano store. For more details contact us at +4522323640.
<?php $__env->stopSection(); ?>
<?php $__env->startSection('keywords'); ?>
luxury italian leather handbags, genuine italian leather handbags, luxury italian leather bags, italian leather bags online, italian leather handbags online, buy italian leather bags, italian leather ladies bags, ladies italian leather handbags
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title1'); ?>
Buy Luxury Italian Genuine Leather Handbags Online | Moretti Milano
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php error_reporting(0);?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <?php if(session()->has('message')): ?>
 <div id="loggedin" class="alert alert-success">
 <?php echo e(session()->get('message')); ?>

 </div>
 <?php endif; ?>
<style>
    .floatleftpad {
        float: right !important;
        padding-left: 15px !important;
        padding-right: 0 !important;
    }
@media  only screen and (max-width: 400px) {
  /* For mobile phones: */
  .floatleftpad {
        float: none !important;
        padding-left: 0 !important;
        padding-right: 15px !important;
    }
}
form {
    padding-top: 52px;
}

</style>
<!-- banner -->
    <div class="banner">
        <div class="container">
            <div class="banner-info animated wow zoomIn" data-wow-delay=".5s">
              <!--  <h3>Free Online Shopping</h3>-->
                <!--<h4>Up to <span>50% <i>Off/-</i></span></h4>-->
                <div class="wmuSlider example1">
                    <div class="wmuSliderWrapper">
                        <article class="custom_heading"> 
                            <div class="banner-wrap">
                                <div class="banner-info1 custom_banner">
                                    <div class="centr"><h1 class="custom_banner_heading">Welcome to Moretti Milano - an Made in Italy luxury leather brand</h1>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <article class="custom_heading"> 
                            <div class="banner-wrap">
                                <div class="banner-info1 custom_banner">
                                    <div class="centr"><h1 class="custom_banner_heading">Add Class to Your Style with Moretti Milano.</h1>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <article class="custom_heading"> 
                            <div class="banner-wrap">
                                <div class="banner-info1 custom_banner">
                                    <div class="centr"><h1 class="custom_banner_heading">Flaunt Your Style with Moretti Milano’s Stylish Handbags and Accessories!</h1>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <article class="custom_heading"> 
                            <div class="banner-wrap">
                                <div class="banner-info1 custom_banner">
                                    <div class="centr"><h1 class="custom_banner_heading">The Moretti Milano Luxury Designer Bag Collection.</h1>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <article class="custom_heading"> 
                            <div class="banner-wrap">
                                <div class="banner-info1 custom_banner">
                                    <div class="centr"><h1 class="custom_banner_heading">Classy, Practical, Durable Bags - That Will Never Go Out Of Style!</h1>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                    <script id="wmu" src="<?php echo e(Request::root()); ?>/public/front/js/jquery.wmuSlider.js" async></script> 
                    <script>
                        wmu.addEventListener('load', function () {
                             $('.example1').wmuSlider(); 
                        });
                    </script> 
            </div>
        </div>
    </div>
 
    <div class="new-collections">
        <div class="container">
            <div class="hideonmobile">
            <div><p class="hd_desp">Moretti Milano offers an exquisite and unique collection of luxury Italian leather handbags and accessories for both women and men. Inspired by the latest emerging trends from Milan and delicately tailored from the finest leather available, Moretti Milano’s long lasting bags and accessories will definitely escort you on your life’s any adventure.</p></div><br>
            <div class="centr"><h2 class="animated wow zoomIn" data-wow-delay=".5s">100% Genuine Italian Leather Handbags and Accessories you’ll Love!</h2></div><hr>
            <div class="centr"><p class="animated wow zoomIn" data-wow-delay=".5s">Traditionally crafted products from genuine, luxury and 100% Italian Leather</p></div><br>
           <!-- <p class="est animated wow zoomIn" data-wow-delay=".5s">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
                deserunt mollit anim id est laborum.</p>-->
            </div>
                
            <div class="col-sm-8"></div>
            <div class="col-sm-4">
                <div class="form-group">
                                <label for="collection">Category:</label>
                                   <form id="myCatForm" action="" method="post">
                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                    <select class="form-control lazySelector myCategory" id="category" name="keyword">

                                        <option value=""> <a href="/">Select All</a></option>
                                        <?php foreach(\App\Modules\Category::all() as $value): ?>
                                        <option <?php if($value->id == @$category): ?><?php echo e('selected'); ?><?php endif; ?> value="<?php echo e($value->id); ?>"><?php echo e($value->category_name); ?></option>
                                        <?php endforeach; ?>
                                         
                                    </select>
                                </form>
                            </div>

            </div>
            <div class="new-collections-grids">
                <!-- start loop -->
                <?php $i=1; ?>
                <?php foreach($products as $product): ?>
                   
                <?php
               // echo $i;
                $folder= $product['photos'][0]['media']['folder'];
                $fileName= $product['photos'][0]['media']['filename'];
                //echo '<pre>';print_r($product['photos'][0]['media']['folder']);die;
                 	 
                $newFolder = str_replace(".","",$folder);
                
                $path = '/home/morettimilano/public_html/crm.morettimilano.com/public'.$newFolder.$fileName;
                
                
                if(!empty($fileName)){
                  
                ?>
                   
                <div class="col-md-3 new-collections-grid <?php if($i%2==0): ?> floatleftpad <?php endif; ?>">
                     
                    <div class="new-collections-grid1 animated wow slideInUp" data-wow-delay=".5s">
                        <div class="new-collections-grid1-image">
                            <a href="<?php echo e(url('/single/')); ?>/<?php echo e(encryptIt($product->id)); ?>" class="product-image"><img src="<?php echo e(IMGPATH); ?>/public/<?php echo e($folder.$fileName); ?>" alt="<?php echo e($product->name); ?>"
                            class="lazy img-responsive"  onerror="this.onerror=null;this.src='<?php echo e(Request::root()); ?>/public/front/images/no_image.jpg'"/></a>
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
                             <?php /*currency($product->web_shop_price)*/ ?>
                             €<?php echo e(number_format($product->web_shop_price/euro()->conversion,2)); ?>

                        <?php else: ?>
                            <?php echo e(currency($product->price)); ?>

                        <?php endif; ?></span><a class="item_add" href="javascript:;" data-toggle="modal" data-target="#myModal" data="<?php echo e($product->name); ?>" data-id="<?php echo e(encryptIt($product->id)); ?>">add to cart </a></p>
                        </div>
                    </div>
                    
                </div>
                 

                
                <?php $i++; } ?>
                     
                <?php endforeach; ?>


            </div>

        </div>
        <!-- <center>
            <div class="pagination">
               <a href="<?php echo e(url('/products')); ?>" class="btn btn-success">Show All Product</a>
            </div>
            <?php  //echo count($products);?>
            <?php if(count($products)==0): ?>
            <p style="color:red">No Record Found!</p>
            <?php endif; ?>
            </center> -->

    </div>
    
    <?php if(!empty($category)): ?>
    <?php
      $cat_name = App\Modules\Category::where('id',$category)->first();
    ?>
    <?php $productModel = app('\App\Modules\Products\ProductRepository'); ?>
    <?php
      $products2 = $productModel->getCat($category);
    ?>
    <div class="new-collections">
        <div class="container">

            <div class="centr"><h2 class="animated wow zoomIn" data-wow-delay=".5s"><?php echo e($cat_name->category_name); ?></h2></div><hr>
             <?php if($cat_name->category_name == 'Women'): ?>
            <div class="centr"><h4 class="animated wow zoomIn cat-h hideonmobile" data-wow-delay=".5s">Stylish & Feminine – Smarten up Your Look!</h4></div><br>
            <div class="centr"><p class="animated wow zoomIn hideonmobile" data-wow-delay=".5s">A never goes out of style collection for Women. Let our ladies Italian leather handbags get the weight off your shoulder. Select from our modish range of bags for women, covering casual business bags, satchels, sling bags, compact pouches, sophisticated totes, travel bags, duffle bags, purses and many more!</p></div>
            <?php endif; ?>
            <?php if($cat_name->category_name == 'Men'): ?>
            <div class="centr"><h4 class="animated wow zoomIn cat-h hideonmobile" data-wow-delay=".5s">Bold & Masculine – Take Your Style a Notch Higher!</h4></div><br>
            <div class="centr"><p class="animated wow zoomIn hideonmobile" data-wow-delay=".5s">A very individual and exquisite collection for Men. Just pick from our masculine collection of bags for men, which transition impeccably from business to leisure, including business briefcases, utility bags, stylish messengers, roomy duffle bags and much more. Make your appearance smart and bold with our luxury Italian leather bags and add more class to your style.</p></div>
            <?php endif; ?>
            <?php if($cat_name->category_name == 'Accessories'): ?>
            <div class="centr"><h4 class="animated wow zoomIn cat-h hideonmobile" data-wow-delay=".5s">Rock Your Look the Right Way with Classy Accessories</h4></div><br>
            <div class="centr"><p class="animated wow zoomIn hideonmobile" data-wow-delay=".5s">Crafted from luxurious and 100% genuine leather that only gets superior with age, Moretti Milano accessories are designed to become a longstanding part of your every day. Choose the one as per your need and personality from our wide range of accessories for both men and women. Make accessorizing an utter joy with us!</p></div>
            <?php endif; ?>
           <!-- <p class="est animated wow zoomIn" data-wow-delay=".5s">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
                deserunt mollit anim id est laborum.</p>-->
               
                
            <div class="col-sm-8"></div>
    
            <div class="new-collections-grids">
                <!-- start loop -->
                <?php $i=1; ?>
                <?php foreach($products2 as $product): ?>
                   
                <?php
               // echo $i;
                $folder= $product['photos'][0]['media']['folder'];
                $fileName= $product['photos'][0]['media']['filename'];
                //echo '<pre>';print_r($product['photos'][0]['media']['folder']);die;

                ?>
                   
                <div class="col-md-3 new-collections-grid <?php if($i%2==0): ?> floatleftpad <?php endif; ?>">
                     
                    <div class="new-collections-grid1 animated wow slideInUp" data-wow-delay=".5s">
                        <div class="new-collections-grid1-image">
                            <a href="<?php echo e(url('/single/')); ?>/<?php echo e(encryptIt($product->id)); ?>" class="product-image"><img src="<?php echo e(IMGPATH); ?>/public/<?php echo e($folder.$fileName); ?>" alt="<?php echo e($product->name); ?>" class="lazy img-responsive"  onerror="this.onerror=null;this.src='<?php echo e(Request::root()); ?>/public/front/images/no_image.jpg'"/></a>
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
                             <?php /*currency($product->web_shop_price)*/ ?>
                              €<?php echo e(number_format($product->web_shop_price/euro()->conversion,2)); ?>

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
        <!-- <center>
            <div class="pagination">
               <a href="<?php echo e(url('/products')); ?>" class="btn btn-success">Show All Product</a>
            </div>
            //echo count($products);?>
            <?php if(count($products)==0): ?>
            <p style="color:red">No Record Found!</p>
            <?php endif; ?>
            </center> -->

    </div>
    <?php else: ?>
    <?php $productModel = app('\App\Modules\Products\ProductRepository'); ?>
    <?php foreach(\App\Modules\Category::all() as $value): ?>
     <?php 
      $products1 = $productModel->getCat($value->id);
     ?>
     <?php if(count($products1)>0): ?>
     
    <div class="new-collections">
        <div class="container">

            <div class="centr"><h2 class="animated wow zoomIn" data-wow-delay=".5s"><?php echo e($value->category_name); ?></h2></div><hr>
            <?php if($value->category_name == 'Women'): ?>
            <div class="centr"><h4 class="animated wow zoomIn cat-h hideonmobile" data-wow-delay=".5s">Stylish & Feminine – Smarten up Your Look!</h4></div><br>
            <div class="centr"><p class="animated wow zoomIn hideonmobile" data-wow-delay=".5s">A never goes out of style collection for Women. Let our ladies Italian leather handbags get the weight off your shoulder. Select from our modish range of bags for women, covering casual business bags, satchels, sling bags, compact pouches, sophisticated totes, travel bags, duffle bags, purses and many more!</p></div>
            <?php endif; ?>
            <?php if($value->category_name == 'Men'): ?>
            <div class="centr"><h4 class="animated wow zoomIn cat-h hideonmobile" data-wow-delay=".5s">Bold & Masculine – Take Your Style a Notch Higher!</h4></div><br>
            <div class="centr"><p class="animated wow zoomIn hideonmobile" data-wow-delay=".5s">A very individual and exquisite collection for Men. Just pick from our masculine collection of bags for men, which transition impeccably from business to leisure, including business briefcases, utility bags, stylish messengers, roomy duffle bags and much more. Make your appearance smart and bold with our luxury Italian leather bags and add more class to your style.</p></div>
            <?php endif; ?>
            <?php if($value->category_name == 'Accessories'): ?>
            <div class="centr"><h4 class="animated wow zoomIn cat-h hideonmobile" data-wow-delay=".5s">Rock Your Look the Right Way with Classy Accessories</h4></div><br>
            <div class="centr"><p class="animated wow zoomIn hideonmobile" data-wow-delay=".5s">Crafted from luxurious and 100% genuine leather that only gets superior with age, Moretti Milano accessories are designed to become a longstanding part of your every day. Choose the one as per your need and personality from our wide range of accessories for both men and women. Make accessorizing an utter joy with us!</p></div>
            <?php endif; ?>
           <!-- <p class="est animated wow zoomIn" data-wow-delay=".5s">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
                deserunt mollit anim id est laborum.</p>-->
               
                
            <div class="col-sm-8"></div>
    
            <div class="new-collections-grids">
                <!-- start loop -->
                <?php $i=1; ?>
                <?php foreach($products1 as $product): ?>
                   
                <?php
                
                
               // echo $i;
                $folder= $product['photos'][0]['media']['folder'];
                $fileName= $product['photos'][0]['media']['filename'];
                //echo '<pre>';print_r($product['photos'][0]['media']['folder']);die;

                ?>
                   
                <div class="col-md-3 new-collections-grid <?php if($i%2==0): ?> floatleftpad <?php endif; ?>">
                     
                    <div class="new-collections-grid1 animated wow slideInUp" data-wow-delay=".5s">
                        <div class="new-collections-grid1-image cstm_img">
                            <a href="<?php echo e(url('/single/')); ?>/<?php echo e(encryptIt($product->id)); ?>" class="product-image"><img src="<?php echo e(IMGPATH); ?>/public/<?php echo e($folder.$fileName); ?>" alt="<?php echo e($product->name); ?>" class="lazy img-responsive"  onerror="this.onerror=null;this.src='<?php echo e(Request::root()); ?>/public/front/images/no_image.jpg'"/></a>
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
                             <?php /*currency($product->web_shop_price)*/ ?>
                              €<?php echo e(number_format($product->web_shop_price/euro()->conversion,2)); ?>

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
        <!-- <center>
            <div class="pagination">
               <a href="<?php echo e(url('/products')); ?>" class="btn btn-success">Show All Product</a>
            </div>
            <?php  //echo count($products);?>
            <?php if(count($products)==0): ?>
            <p style="color:red">No Record Found!</p>
            <?php endif; ?>
            </center> -->

    </div>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
     <div class="centr">
            <div class="pagination">
               <a href="<?php echo e(url('/products')); ?>" class="btn btn-success">Show All Product</a>
            </div>
            <?php  //echo count($products);?>
            <?php if(count($products)==0): ?>
            <p class="cstm_page">No Record Found!</p>
            <?php endif; ?>
            </div>
            
            

    <div class="collections-bottom cstm_bottom">
        <div class="container">
            <div class="collections-bottom-grids">
                <div class="collections-bottom-grid animated wow slideInLeft" data-wow-delay=".5s">
                    <h1><span>Luxury Leather Handbags</span><span>Womens, Mens & Accessoriess</span></h1>
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




  
</div>

</body>
</html>



<!--<script src="//cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js" async></script>-->

<script>

   
    $(document).ready(function(){
        
         setTimeout(function() {
          $("#loggedin").hide();
           }, 3000);
        
         $('.myCategory').change(function(){
                $('#myCatForm').submit();
            })
        
        
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
                    if(stockStatus == undefined){
                        $("#stock-label").text("Please select a color!!").css({"color": "red", "font-style": "oblique"});
                        $('.btn-success').hide();
                    }
                    else {
                    if(stockStatus=='Out Of Stock'){
                        $('.addtocart').hide();
                     }else{
                         $('.addtocart').show();
                     }
                    $("[name=variant_id]").val($('option:selected',this).attr('data-id'));
                    $("#stock-label").text($('option:selected',this).attr('data-stock-label')+' ('+Qty+')').css({"color": "#737373", "font-style": "normal"});
                    $(".qty1").val(Qty);
                    $(".color-box").removeClass('active');
                    $(this).addClass('active');
                    return false;
                    }
                });
        
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.front-layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>