@extends('webpanel.layouts.front-layout')
@section('title')
@if(!empty($product->name))
{{$product->name}} 
@else
Products
@endif
@stop
@section('description1')
Buy genuine Italian leather handbags featured products and accessories for men & women at Moretti Milano online store. Contact us!
@stop
@section('keywords')
luxury italian leather handbags, genuine italian leather handbags, luxury italian leather bags, italian leather bags online, italian leather handbags online, buy italian leather bags, italian leather ladies bags, ladies italian leather handbags
@stop
@section('title1')
Italian Leather Handbags Products Online | Moretti Milano
@stop
@section('content')
<?php error_reporting(0); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
    <div class="new-collections">
        <div class="container">
            <div class="centr"><h1 class="animated wow zoomIn" data-wow-delay=".5s">All Products</h1></div><hr>
            <div class="centr"><h4 class="animated wow zoomIn cat-h" data-wow-delay=".5s">Moretti Milano’s Trendy Collection of Luxury Leather Handbags & Accessories</h4></div><br>
            <div class="centr"><p class="animated wow zoomIn" data-wow-delay=".5s">Explore our range of trendiest luxury leather tote bags, mini handbags, compact pouches, duffle or travel bags, business bags, satchels, saddle bags, backpacks, briefcase bags and other accessories for him & her. All of our practical yet up-to-the-minute Moretti Milano products are handcrafted in Italy, using the best 100% authentic Italian leather. So, look no further … Just shop with the confidence!</p></div>
            <!-- <p class="est animated wow zoomIn" data-wow-delay=".5s">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
                deserunt mollit anim id est laborum.</p> -->
            <div class="new-collections-grids">
                <!-- start loop -->
                <?php $i=1; ?>
                @foreach($products as $product)
                    
                <?php
               // echo $i;
                $folder= $product['photos'][0]['media']['folder'];
                $fileName= $product['photos'][0]['media']['filename'];
                //echo '<pre>';print_r($product['photos'][0]['media']['folder']);die;

                ?>
                 
                <div class="col-md-3 new-collections-grid">
                     
                    <div class="new-collections-grid1 animated wow slideInUp" data-wow-delay=".5s">
                        <div class="new-collections-grid1-image cstm_product_img">
                            <a href="{{url('/single/')}}/{{encryptIt($product->id)}}" class="product-image">
                                <img src="{{IMGPATH}}/public/{{$folder.$fileName}}" alt="{{$product->name}}" class="img-responsive"  onerror="this.onerror=null;this.src='{{Request::root()}}/public/front/images/no_image.jpg'" />
                            </a>
                            <div class="new-collections-grid1-image-pos">
                                <a href="{{url('/single/')}}/{{encryptIt($product->id)}}">Quick View</a>
                            </div>
                            <div class="new-collections-grid1-right">
                                 
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
                            <p><!-- <i>$280</i> --> <span class="item_price">
                        @if($product->web_shop_price !=0)
                             {{--currency($product->web_shop_price)--}}
                              €{{number_format($product->web_shop_price/euro()->conversion,2)}}
                        @else
                            {{currency($product->price)}}
                        @endif
                    </span><a class="item_add" href="javascript:;" data-toggle="modal" data-target="#myModal" data="{{$product->name}}" data-id="{{encryptIt($product->id)}}">add to cart </a></p>
                        </div>
                    </div>
                    
                </div>
                 

                
                <?php $i++; ?>
                   
                @endforeach


            </div>

        </div>
        <div class="centr">
            <div class="pagination">
                {{$products->render()}}
            </div>
            <?php  //echo count($products);?>
            @if(count($products)==0)
            <p class="cstm_product_page">No Record Found!</p>
            @endif
            </div>

    </div>

 
 
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
        // $(document).on('click',".color-box", function (e) {
                     
        //             var Qty= $(this).attr('data-qty');
        //             var stockStatus= $(this).attr('data-stock-label');
        //             if(stockStatus=='Out Of Stock'){
        //                 $('.addtocart').prop('disabled',true)
        //              }else{
        //                  $('.addtocart').prop('disabled',false)
        //              }
        //             $("[name=variant_id]").val($(this).attr('data-id'));
        //             $("#stock-label").text($(this).attr('data-stock-label')+' ('+Qty+')');
        //             $(".qty1").val(Qty);
        //             $(".color-box").removeClass('active');
        //             $(this).addClass('active');
        //             return false;
        //         });
            
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
                    $('option:selected').removeClass('active');
                    $('option:selected',this).addClass('active');
                    return false;
                });
        
    </script>

@endsection