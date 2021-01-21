@extends('webpanel.layouts.front-layout')
@section('title')
The Latest in Powerful 100% Italian Leather Handbags |Moretti Milano
@stop
@section('description1')
Buy online Italian genuine leather luxury ladies handbags and men accessories at Moretti Milano store. For more details contact us at +4522323640.
@stop
@section('keywords')
luxury italian leather handbags, genuine italian leather handbags, luxury italian leather bags, italian leather bags online, italian leather handbags online, buy italian leather bags, italian leather ladies bags, ladies italian leather handbags
@stop
@section('title1')
Buy Luxury Italian Genuine Leather Handbags Online | Moretti Milano
@stop
@section('content')
<?php error_reporting(0);?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 @if(session()->has('message'))
 <div id="loggedin" class="alert alert-success">
 {{ session()->get('message') }}
 </div>
 @endif
<style>
    .floatleftpad {
        float: right !important;
        padding-left: 15px !important;
        padding-right: 0 !important;
    }
@media only screen and (max-width: 400px) {
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
input.newsbtn {
     
    padding: -8px 0;
    
    outline: 0;
    padding: 4px 0;
    background: #d8703f;
    border: none;
    font-size: 1em;
    color: #fff;
    width: 14%;
    /* margin-left: 2em; */
}
.row {
    margin-right: -15px;
    margin-left: -15px;
    margin-bottom: -15px;
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
                    <script id="wmu" src="{{Request::root()}}/public/front/js/jquery.wmuSlider.js" async></script> 
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
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <select class="form-control lazySelector myCategory" id="category" name="keyword">

                                        <option value=""> <a href="/">Select All</a></option>
                                        @foreach(\App\Modules\Category::all() as $value)
                                        <option @if($value->id == @$category){{'selected'}}@endif value="{{$value->id}}">{{$value->category_name}}</option>
                                        @endforeach
                                         
                                    </select>
                                </form>
                            </div>

            </div>
            <div class="new-collections-grids">
                <!-- start loop -->
                <?php $i=1; ?>
                @foreach($products as $product)
                   
                <?php
               // echo $i;
                $folder= $product['photos'][0]['media']['folder'];
                $fileName= $product['photos'][0]['media']['filename'];
                //echo '<pre>';print_r($product['photos'][0]['media']['folder']);die;
                 	 
                $newFolder = str_replace(".","",$folder);
                
                $path = '/home/morettimilano/public_html/crm.morettimilano.com/public'.$newFolder.$fileName;
                
                
                if(!empty($fileName)){
                  
                ?>
                   
                <div class="col-md-3 new-collections-grid @if($i%2==0) floatleftpad @endif">
                     
                    <div class="new-collections-grid1 animated wow slideInUp" data-wow-delay=".5s">
                        <div class="new-collections-grid1-image">
                            <a href="{{url('/single/')}}/{{encryptIt($product->id)}}" class="product-image"><img src="{{IMGPATH}}/public/{{$folder.$fileName}}" alt="{{$product->name}}"
                            class="lazy img-responsive"  onerror="this.onerror=null;this.src='{{Request::root()}}/public/front/images/no_image.jpg'"/></a>
                            <div class="new-collections-grid1-image-pos">
                                <a href="{{url('/single/')}}/{{encryptIt($product->id)}}">Quick View</a>
                            </div>
                            <div class="new-collections-grid1-right">
                                <div class="rating">
                                    <!-- <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/2.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/2.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/1.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/1.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/1.png" alt=" " class="img-responsive" />
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
                        <h4><a href="{{url('/single/')}}/{{encryptIt($product->id)}}">{{$product->name}}</a></h4>
                        <!-- <p>Vel illum qui dolorem eum fugiat.</p> -->
                        <div class="new-collections-grid1-left simpleCart_shelfItem">
                            <p><!-- <i>$280</i> --> <span class="item_price">@if($product->web_shop_price !=0)
                             {{--currency($product->web_shop_price)--}}
                             €{{number_format($product->web_shop_price/euro()->conversion,2)}}
                        @else
                            {{currency($product->price)}}
                        @endif</span><a class="item_add" href="javascript:;" data-toggle="modal" data-target="#myModal" data="{{$product->name}}" data-id="{{encryptIt($product->id)}}">add to cart </a></p>
                        </div>
                    </div>
                    
                </div>
                 

                
                <?php $i++; } ?>
                     
                @endforeach


            </div>

        </div>
        <!-- <center>
            <div class="pagination">
               <a href="{{url('/products')}}" class="btn btn-success">Show All Product</a>
            </div>
            <?php  //echo count($products);?>
            @if(count($products)==0)
            <p style="color:red">No Record Found!</p>
            @endif
            </center> -->

    </div>
    
    @if(!empty($category))
    <?php
      $cat_name = App\Modules\Category::where('id',$category)->first();
    ?>
    @inject('productModel','\App\Modules\Products\ProductRepository')
    <?php
      $products2 = $productModel->getCat($category);
    ?>
    <div class="new-collections">
        <div class="container">

            <div class="centr"><h2 class="animated wow zoomIn" data-wow-delay=".5s">{{$cat_name->category_name}}</h2></div><hr>
             @if($cat_name->category_name == 'Women')
            <div class="centr"><h4 class="animated wow zoomIn cat-h hideonmobile" data-wow-delay=".5s">Stylish & Feminine – Smarten up Your Look!</h4></div><br>
            <div class="centr"><p class="animated wow zoomIn hideonmobile" data-wow-delay=".5s">A never goes out of style collection for Women. Let our ladies Italian leather handbags get the weight off your shoulder. Select from our modish range of bags for women, covering casual business bags, satchels, sling bags, compact pouches, sophisticated totes, travel bags, duffle bags, purses and many more!</p></div>
            @endif
            @if($cat_name->category_name == 'Men')
            <div class="centr"><h4 class="animated wow zoomIn cat-h hideonmobile" data-wow-delay=".5s">Bold & Masculine – Take Your Style a Notch Higher!</h4></div><br>
            <div class="centr"><p class="animated wow zoomIn hideonmobile" data-wow-delay=".5s">A very individual and exquisite collection for Men. Just pick from our masculine collection of bags for men, which transition impeccably from business to leisure, including business briefcases, utility bags, stylish messengers, roomy duffle bags and much more. Make your appearance smart and bold with our luxury Italian leather bags and add more class to your style.</p></div>
            @endif
            @if($cat_name->category_name == 'Accessories')
            <div class="centr"><h4 class="animated wow zoomIn cat-h hideonmobile" data-wow-delay=".5s">Rock Your Look the Right Way with Classy Accessories</h4></div><br>
            <div class="centr"><p class="animated wow zoomIn hideonmobile" data-wow-delay=".5s">Crafted from luxurious and 100% genuine leather that only gets superior with age, Moretti Milano accessories are designed to become a longstanding part of your every day. Choose the one as per your need and personality from our wide range of accessories for both men and women. Make accessorizing an utter joy with us!</p></div>
            @endif
           <!-- <p class="est animated wow zoomIn" data-wow-delay=".5s">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
                deserunt mollit anim id est laborum.</p>-->
               
                
            <div class="col-sm-8"></div>
    
            <div class="new-collections-grids">
                <!-- start loop -->
                <?php $i=1; ?>
                @foreach($products2 as $product)
                   
                <?php
               // echo $i;
                $folder= $product['photos'][0]['media']['folder'];
                $fileName= $product['photos'][0]['media']['filename'];
                //echo '<pre>';print_r($product['photos'][0]['media']['folder']);die;

                ?>
                   
                <div class="col-md-3 new-collections-grid @if($i%2==0) floatleftpad @endif">
                     
                    <div class="new-collections-grid1 animated wow slideInUp" data-wow-delay=".5s">
                        <div class="new-collections-grid1-image">
                            <a href="{{url('/single/')}}/{{encryptIt($product->id)}}" class="product-image"><img src="{{IMGPATH}}/public/{{$folder.$fileName}}" alt="{{$product->name}}" class="lazy img-responsive"  onerror="this.onerror=null;this.src='{{Request::root()}}/public/front/images/no_image.jpg'"/></a>
                            <div class="new-collections-grid1-image-pos">
                                <a href="{{url('/single/')}}/{{encryptIt($product->id)}}">Quick View</a>
                            </div>
                            <div class="new-collections-grid1-right">
                                <div class="rating">
                                    <!-- <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/2.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/2.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/1.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/1.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/1.png" alt=" " class="img-responsive" />
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
                        <h4><a href="{{url('/single/')}}/{{encryptIt($product->id)}}">{{$product->name}}</a></h4>
                        <!-- <p>Vel illum qui dolorem eum fugiat.</p> -->
                        <div class="new-collections-grid1-left simpleCart_shelfItem">
                            <p><!-- <i>$280</i> --> <span class="item_price">@if($product->web_shop_price !=0)
                             {{--currency($product->web_shop_price)--}}
                              €{{number_format($product->web_shop_price/euro()->conversion,2)}}
                        @else
                            {{currency($product->price)}}
                        @endif</span><a class="item_add" href="javascript:;" data-toggle="modal" data-target="#myModal" data="{{$product->name}}" data-id="{{encryptIt($product->id)}}">add to cart </a></p>
                        </div>
                    </div>
                    
                </div>
                 

                
                <?php $i++; ?>
                     
                @endforeach


            </div>

        </div>
        <!-- <center>
            <div class="pagination">
               <a href="{{url('/products')}}" class="btn btn-success">Show All Product</a>
            </div>
            //echo count($products);?>
            @if(count($products)==0)
            <p style="color:red">No Record Found!</p>
            @endif
            </center> -->

    </div>
    @else
    @inject('productModel','\App\Modules\Products\ProductRepository')
    @foreach(\App\Modules\Category::all() as $value)
     <?php 
      $products1 = $productModel->getCat($value->id);
     ?>
     @if(count($products1)>0)
     
    <div class="new-collections">
        <div class="container">

            <div class="centr"><h2 class="animated wow zoomIn" data-wow-delay=".5s">{{$value->category_name}}</h2></div><hr>
            @if($value->category_name == 'Women')
            <div class="centr"><h4 class="animated wow zoomIn cat-h hideonmobile" data-wow-delay=".5s">Stylish & Feminine – Smarten up Your Look!</h4></div><br>
            <div class="centr"><p class="animated wow zoomIn hideonmobile" data-wow-delay=".5s">A never goes out of style collection for Women. Let our ladies Italian leather handbags get the weight off your shoulder. Select from our modish range of bags for women, covering casual business bags, satchels, sling bags, compact pouches, sophisticated totes, travel bags, duffle bags, purses and many more!</p></div>
            @endif
            @if($value->category_name == 'Men')
            <div class="centr"><h4 class="animated wow zoomIn cat-h hideonmobile" data-wow-delay=".5s">Bold & Masculine – Take Your Style a Notch Higher!</h4></div><br>
            <div class="centr"><p class="animated wow zoomIn hideonmobile" data-wow-delay=".5s">A very individual and exquisite collection for Men. Just pick from our masculine collection of bags for men, which transition impeccably from business to leisure, including business briefcases, utility bags, stylish messengers, roomy duffle bags and much more. Make your appearance smart and bold with our luxury Italian leather bags and add more class to your style.</p></div>
            @endif
            @if($value->category_name == 'Accessories')
            <div class="centr"><h4 class="animated wow zoomIn cat-h hideonmobile" data-wow-delay=".5s">Rock Your Look the Right Way with Classy Accessories</h4></div><br>
            <div class="centr"><p class="animated wow zoomIn hideonmobile" data-wow-delay=".5s">Crafted from luxurious and 100% genuine leather that only gets superior with age, Moretti Milano accessories are designed to become a longstanding part of your every day. Choose the one as per your need and personality from our wide range of accessories for both men and women. Make accessorizing an utter joy with us!</p></div>
            @endif
           <!-- <p class="est animated wow zoomIn" data-wow-delay=".5s">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
                deserunt mollit anim id est laborum.</p>-->
               
                
            <div class="col-sm-8"></div>
    
            <div class="new-collections-grids">
                <!-- start loop -->
                <?php $i=1; ?>
                @foreach($products1 as $product)
                   
                <?php
                
                
               // echo $i;
                $folder= $product['photos'][0]['media']['folder'];
                $fileName= $product['photos'][0]['media']['filename'];
                //echo '<pre>';print_r($product['photos'][0]['media']['folder']);die;

                ?>
                   
                <div class="col-md-3 new-collections-grid @if($i%2==0) floatleftpad @endif">
                     
                    <div class="new-collections-grid1 animated wow slideInUp" data-wow-delay=".5s">
                        <div class="new-collections-grid1-image cstm_img">
                            <a href="{{url('/single/')}}/{{encryptIt($product->id)}}" class="product-image"><img src="{{IMGPATH}}/public/{{$folder.$fileName}}" alt="{{$product->name}}" class="lazy img-responsive"  onerror="this.onerror=null;this.src='{{Request::root()}}/public/front/images/no_image.jpg'"/></a>
                            <div class="new-collections-grid1-image-pos">
                                <a href="{{url('/single/')}}/{{encryptIt($product->id)}}">Quick View</a>
                            </div>
                            <div class="new-collections-grid1-right">
                                <div class="rating">
                                    <!-- <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/2.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/2.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/1.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/1.png" alt=" " class="img-responsive" />
                                    </div>
                                    <div class="rating-left">
                                        <img src="{{Request::root()}}/public/front/images/1.png" alt=" " class="img-responsive" />
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
                        <h4><a href="{{url('/single/')}}/{{encryptIt($product->id)}}">{{$product->name}}</a></h4>
                        <!-- <p>Vel illum qui dolorem eum fugiat.</p> -->
                        <div class="new-collections-grid1-left simpleCart_shelfItem">
                            <p><!-- <i>$280</i> --> <span class="item_price">@if($product->web_shop_price !=0)
                             {{--currency($product->web_shop_price)--}}
                              €{{number_format($product->web_shop_price/euro()->conversion,2)}}
                        @else
                            {{currency($product->price)}}
                        @endif</span><a class="item_add" href="javascript:;" data-toggle="modal" data-target="#myModal" data="{{$product->name}}" data-id="{{encryptIt($product->id)}}">add to cart </a></p>
                        </div>
                    </div>
                    
                </div>
                 

                
                <?php $i++; ?>
                     
                @endforeach


            </div>

        </div>
        <!-- <center>
            <div class="pagination">
               <a href="{{url('/products')}}" class="btn btn-success">Show All Product</a>
            </div>
            <?php  //echo count($products);?>
            @if(count($products)==0)
            <p style="color:red">No Record Found!</p>
            @endif
            </center> -->

    </div>
    @endif
    @endforeach
    @endif
     <div class="centr">
            <div class="pagination">
               <a href="{{url('/products')}}" class="btn btn-success">Show All Product</a>
            </div>
            <?php  //echo count($products);?>
            @if(count($products)==0)
            <p class="cstm_page">No Record Found!</p>
            @endif
            </div>
            
            <div class="collections-bottom cstm_bottom">
        <div class="container">
           <!--  <div class="collections-bottom-grids">
                <div class="collections-bottom-grid animated wow slideInLeft" data-wow-delay=".5s">
                    <h1><span>Luxury Leather Handbags</span><span>Womens, Mens & Accessoriess</span></h1>
                </div>
            </div> -->
            <div class="newsletter animated wow slideInUp" data-wow-delay=".5s">
                <h3>Newsletter</h3>
                <p>Join us now to get all news and special offers.</p>
                  
                   <!--  <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> -->
                   <!--  <input type="email" class="newemail" > -->
                    <!--<br>-->
                    <!--<br>-->
                    <!-- <input type="checkbox" id="newscheckbox" >Add news letter list-->
                   <!--  <label for="vehicle1"> Add news letter list</label><br> -->
                    <!-- <input type="submit" value="Subscribe" class="newsbtn1231"  data-toggle="modal" data-target="#myModalnews" > -->
                  
               <p class="message"></p>
               <p class="emessage"></p>
            </div>
        </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>

    function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
    
    function error($msg){
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: $msg
                 
                })       
        }
        function success($msg1){
                        Swal.fire({
                        type: 'success',
                        title: 'Success...',
                        text: $msg1,
                        timer: 3000
                        })       
        }

    $(document).ready(function(){
        
        
        //  for news leter
        $('.newsbtn').click(function(event){

            var newemail= $('.newemail').val();
           alert(newemail);

            

            if(newemail==""){
                
                error('Please Enter Email.');
                return false;
            }

            if (!ValidateEmail($(".newemail").val())) {
 
                error('Invalid email address.');
                return false;
            }
            $('.newsbtn').prop('disabled',true);
            var checked= 1;
            $.ajax({
            url:"{{url('/news-letter')}}",
            method:'post',
            data:{'_token':"{{csrf_token()}}",'email':newemail,'checkbox':checked},
            success:function(ress){
                $('.newsbtn').prop('disabled',false);
                $('.newemail').val(' ');
                $('#newscheckbox').prop('checked',false)

                if(ress==1){
                    error('You have already subscriber.');
                }else{
                    
                     $('#myModalnews').modal('hide');

                    success('Thankyou for your subsription.');
                }
                 
            }
            });

             
            event.preventDefault();
        });
        
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
            url:"{{url('/product-info')}}",
            method:'post',
            data:{'_token':"{{csrf_token()}}",'keyword':name},
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

@endsection