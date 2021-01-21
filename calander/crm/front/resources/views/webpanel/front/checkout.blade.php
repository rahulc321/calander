@extends('webpanel.layouts.front-layout')
@section('title')
Cart
@stop
@section('content')
<?php error_reporting(0)?>
 <!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="{{url('/products')}}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Checkout Page</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- checkout -->

 	<div class="checkout">
		<div class="container">
			<p class="alert alert-info cstm_checkout_success">You have Successfully Updated Cart <img src="{{Request::root()}}/public/front/images/bag.png" alt="Bag" /></p>

			<div class="order-info">
				<div id="notificationArea">
					<?php
					ValidationNotification($errors);
					Notification();
					?>
				</div>
			</div>

			 <?php $totalItems = $order->items()->count('id'); ?>
			<h3 class="animated wow slideInLeft" data-wow-delay=".5s">Your shopping cart contains: <span>
			{{$totalItems}} Products</span></h3>
			@if($totalItems > 0)
			<span class="cstm_checkout_sp"> 
                <small class="cstm_checkout_oid">ORDER ID: {{ $order->OID }}</small>
            </span>
            <div class="range cstm_checkout_odate">
            Order Date: {{ $order->createdDate() }}<br>
           
            
        	</div>
        	@endif
        	@if(!$order || $totalItems == 0)

            <div class="callout callout-danger cstm_checkout_dng">
                <h5><i class="icon-cart-add"></i><img src="{{Request::root()}}/public/front/images/bag.png" alt="Bag" /> No Items in a cart</h5>
                <p>No items in cart. Please add new items first. <a href="{{url('/')}}">Click
                        here</a> to add item.</p>
            </div>

        @else


			<div class="checkout-right animated wow slideInUp" data-wow-delay=".5s">
				<table class="timetable_sub">
					<thead>
						<tr>
							<th>SL No.</th>	
							<th>Product</th>
							<th>Qty</th>
							<th>Product Name</th>
							<th>Product Color</th>
							<th>Price</th>
							<th>Total</th>
							<th>Remove</th>
						</tr>
					</thead>

					<?php
					$i=1;
					 $items = $order->items()->with('product.photos')->get(); $grandTotal = 0;?>
                	@foreach($items as $k => $item)

                	<?php
                	// echo '<pre>';print_r($item['product']['photos'][0]['media']['filename']);
                    if(isset($item['product']['photos'][0]['media']['folder']))
                	$folder= $item['product']['photos'][0]['media']['folder'];
					$fileName= $item['product']['photos'][0]['media']['filename'];
                     // echo '<pre>';print_r($item);die;
                	?>

					<tr class="rem1">
						<td class="invert">1</td>
						<td class="invert-image"><img src="{{IMGPATH}}/public/{{$folder.$fileName}}" alt="{{ @$item->product->name }}" class="img-responsive cstm_checkout_tdimg" onerror='this.onerror=null;this.src="<?php echo NO_IMG; ?>"'/></td>
						<td class="invert">
							 <div class="quantity"> 
								<div class="quantity-select">    <div class="centr">                       
									<input type="number" class="form-control inc kk cstm_checkout_inp" name="qty" value="{{ $item->qty }}" min="1" max="{{$variantData['qty']}}" data-qty="{{$variantData['qty']}}" data="<?=$i?>" data-productid='{{$item->id}}'>
								</div>
								</div>
							</div>
						</td>
						<td class="invert">{{ @$item->product->name }}</td>
						<td>{{ @$item->variant->color->name }}</td>
						<td class="invert product_price_<?=$i?>" data-price="{{$item['product']['web_shop_price']/euro()->conversion}}"> @if($item['product']['web_shop_price'] !=0)
                            {{--currency($item['product']['web_shop_price'])--}}
                             €{{number_format($item['product']['web_shop_price']/euro()->conversion,2)}}
                            
                         @else
                            {{currency($item['product']['price'])}}
                         @endif
						</td>
						<?php 
						   if($item['product']['web_shop_price'] !=0)
							{
							 $totalPrice= $item->qty*@$item['product']['web_shop_price'];
						    } else{
						     $totalPrice= $item->qty*@$item['product']['price'];
						    }
						?>

						<td class="invert">
							<input type="hidden" class="perProductPrice_<?=$i?>" value="<?=$totalPrice/euro()->conversion?>">
							<span class="pp_<?=$i?>">
							    <!--<?=currency($totalPrice)?>-->
							     €{{number_format($totalPrice/euro()->conversion,2)}}
							    </span>
						</td>
						<td class="invert">
							<div class="rem">
								<a title="Delete Item"
                               href="<?php echo url('orders/delete-cart-item/' . encrypt($item->id)); ?>"
                               class="delete close1 btn btn-danger"
                               data-id="<?php echo $item->id; ?>"
                               data-token="<?php echo urlencode(md5($item->id)); ?>"><i class="icon-remove4"></i></a>
							</div>
							
						</td>
					</tr>

					<?php $i++;?>
					 @endforeach
				</table>
			</div>
            <div class="checkout-left">	
				<div class="checkout-left-basket animated wow slideInLeft" data-wow-delay=".5s">
					<h5>Apply Coupon Code</h5>
					<div class="form">
						<input type="text" class="form-control amtcode"   placeholder="Coupon Code">
						<a href="javascript:;" class="btn btn-success apply">Apply</a>
					</div>
					
				</div>

		


				
				 


				<!-- <div class="checkout-right-basket animated wow slideInRight" data-wow-delay=".5s">
					<a href="single.html"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Continue Shopping</a>
				</div> -->
				<div class="clearfix"> </div>
			</div>
			
			

			<?php 
			$cpnData= App\Models\CouponDetail::where('orderId',$order->OID)->first();

			?>
			<div class="checkout-left">	
				<div class="checkout-left-basket animated wow slideInLeft" data-wow-delay=".5s">
					<!--<h4>Continue to basket</h4>-->
					<ul>
						<li>Total <i>-</i> <span class="total3"></span></li>
						@if($cpnData)
						 <li class="per">Discount <i>-</i> <span class="discount"></span></li>
						 @endif
						<li>Grand Total <i>-</i> <span class="grand"></span>
						<input type="hidden" class="grandtotal" >
						</li>
					</ul>
				</div>

		


				
				 


				<!-- <div class="checkout-right-basket animated wow slideInRight" data-wow-delay=".5s">
					<a href="single.html"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Continue Shopping</a>
				</div> -->
				<div class="clearfix"> </div>
			</div>
			<div class="process cstm_checkout_pro">
					<!-- <a class="btn btn-warning btn-sm" href="{{ url('/orders/place/xl') }}">Place Order</a> -->
					@if(Auth::id())
					<div id="paypal-button-container"></div>
					@else
					<div class="col-sm-4">
					<div class="form-group">
                        <label for="guest_email" class="cstm_checkout_guestem">Email:</label>                       
                            <input type="text" class="form-control" id="guest_email" name="email">
                    </div>
                    <p id="notify" class="cstm_checkout_notify"></p>
                    <div class="form-group cstm_checkout_frm">                     
                            <input type="submit" value="Submit" id="guest_check" class="btn btn-success submit-btn">    
                    </div>
                    <br><br>
                    <div id="guest_details">                        
                    </div>
                    </div>                 
                    </div>
                    </div>
					@endif
				</div>
			 
				@endif

		</div>
	</div>

<!-- //checkout -->

<?php
		//echo '<pre>';print_r($cpnData);
// 	if(currency("")=='DKK0.00'){
// 		$sign = 'DKK';
// 	}else{
// 		$sign = 'EUR';
// 	}
 	$sign = 'EUR'
?>
<!-- paypal -->
<!--<script src="https://www.paypal.com/sdk/js?client-id=ATrvvkM9mwRMXp2ZUbEpRXpNVRv8M-KBdLLx8-803Gr2N9N5_NwxBVDmkd6yYf6P91PtEnfOXROC_xM1&currency=<?=$sign?>"></script>-->
<!--Sandbox -->
<script src="https://www.paypal.com/sdk/js?client-id=Ac1lzQuJIh7LEJfXaqnvv_-y0mL-DnREug7hzF1hsJvAkbrcWO0ESkkeRIEpp1P8NoXgSwqIkuo_-c7s&currency=<?=$sign?>"></script>
 
 
<!--Live Paypal
<script src="https://www.paypal.com/sdk/js?client-id=Aaz0KxJeC7NSK1k2uiqvjOO-YNDl4zq2PemaKYLMAzrtDcYBy5caDg6FrE8K7L4pqdTZkaU0vpqV6YHn&currency=<?=$sign?>"></script>-->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script>
		
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({
        	style: {
        size: 'small',
        color: 'gold',
        shape: 'pill',
        label: 'pay',
        tagline: false
        
    },

            // Set up the transaction
            createOrder: function(data, actions) {
            	var totalAmount = $('.grandtotal').val();
            	//alert(totalAmount);
            	//return false;
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: totalAmount
                        }
                    }]
                });
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {

                	//console.log(details[ask]);
                	// status
                	 //console.log(details.purchase_units[0].payments.captures[0].status);
                	// transaction id
                	 //console.log(details.purchase_units[0].payments.captures[0].id);
                	// currency
                	//console.log(details.purchase_units[0].payments.captures[0]['amount'].currency_code);

                	// amount
                	//console.log(details.purchase_units[0].payments.captures[0]['amount'].value);

                	var paymentStatus= details.status;
                	console.log(paymentStatus);
                	var transactionId= details.purchase_units[0].payments.captures[0].id;

                	var currency = details.purchase_units[0].payments.captures[0]['amount'].currency_code;

                	var amount= details.purchase_units[0].payments.captures[0]['amount'].value;
                	 
                	 if(paymentStatus == 'COMPLETED'){
                	 	Swal.fire({
						title: 'Please Wait!! Your Transaction is processing.....',
						showConfirmButton: false, 
						})
                		$.ajax({
                			url:"{{url('/paypal-transaction')}}",
                			method:'post',
                			data:{'_token':"{{csrf_token()}}",'paymentStatus':paymentStatus,'transactionId':transactionId,'currency':currency,'amount':amount},
                			success:function(result){
                				 window.location.replace("{{ url('/orders/place/xl') }}");
                				//alert(result)

								Swal.fire({
								type: 'success',
								title: 'Success...',
								text: 'Congratulations !! Your Payment has been Received.',
								timer: 3000
								})
                				 //window.location.replace("https://shop.morettimilano.com/orders/place/xl");
                				 //window.location.replace("http://localhost/crm/front/orders/place/xl");
                				 return false;
                			}
                		});

                	 }


                	 
                    // Show a success message to the buyer
                    //alert('Transaction completed by ' + details.payer.name.given_name + '!');
                });
            },
            onError: function (err) {
    // Show an error page here, when an error occurs
    		//alert(err)
            if(err != "Error: Document is ready and element #paypal-button-container does not exist"){

            }else if(err =="Order could not be captured"){
				Swal.fire({
					type: 'error',
					title: 'Oops...',
					text: 'Transaction failed! Please Try Again After Few Minuts.'
				 
				})
			}

            }


        }).render('#paypal-button-container');
    </script>



<!-- paypal -->








	 
	 

	<script>
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
		// working on onload
		 $('.apply').click(function(){
		 	var code= $('.amtcode').val();
		 	if(code==""){ 
		 		error('Please Enter Coupon Code');
		 		return false;
		 	}

		 	$.ajax({
				url:"{{url('/apply-coupon')}}",
				method:'post',
				data:{'_token':"{{csrf_token()}}",'code':code,'orderId':"{{ $order->OID }}"},
				success:function(result){
					if(result==0){
						error('Please Enter Valid Code');
		 				return false;
					}else if(result==1){
						success('Congratulations !! Your Coupon Code Successfully Apply');
						location.reload();
						/*window.location.replace("https://shop.morettimilano.com/orders/place/xl");
						return false;*/
					}else if(result==2){
						error('This Coupon code has been Expired!');
		 				return false;
						 

					}
				}
			});


		 });
		//alert(localStorage.name1);
		//localStorage.clear()
		
		//03-01-2020
        $('#notify').hide();

        function validateEmail($email) {
		  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		  return emailReg.test( $email );
        }

		$("#guest_check").click(function() {
		   var email = $('#guest_email').val();	

		   if(email == ""){
		   	$('#notify').show().html("Please enter your email!");
		   	$('#guest_details').hide();
		   	return false;
		   }else if( !validateEmail(email)){ 
            $('#notify').show().html("Please enter a valid email!");
            $('#guest_details').hide();
            return false;
		   }
		   else{		   		
			$.ajax({
                url: "{{url('/check-guest')}}",
                type: 'post',
                data: {'_token':"{{csrf_token()}}",'guestEmail':email},
                success:function(response){
                	 $('#guest_details').show().html(response);
                	 $('#notify').hide();
                }
			});
		   }
			});

		//03-01-2020
		
			var sum = 0;
			$('.kk').each(function(){
				var id = $(this).attr('data');
				var val = $(this).val();
				var price = $('.product_price_'+id).attr('data-price');
				var actprice= val*price;
				$('.subp'+id).text(actprice);
				var subp= $('.perProductPrice_'+id).val();
				sum += Number(subp);
				 
			});

			var allcur= "<?=currency("");?>";
				

				if(allcur=='DKK0.00'){
					var sign = 'DKK';
				}else{
					var sign = '€';
				}
			var sum1= sum.toFixed(2);

			var cpntype= "{{$cpnData->cpn_type}}";
			//alert(cpntype);
			if(cpntype=='fixed'){
				var pricecpn="{{number_format($cpnData->cpn_price/euro()->conversion)}}";
				var applySum= sum1-pricecpn;
				//alert(applySum);

				$('.discount').text(sign+pricecpn);
				$('.total3').text(sign+sum1);
				$('.grand').text(sign+applySum);
				$('.grandtotal').val(applySum);
			}else if(cpntype=='percent'){
				var pricecpn="{{$cpnData->cpn_price}}";
				var applySum= sum1*pricecpn/100;
				var totalAmt1= sum1-applySum;
				 
				//$('.discount').text(sign+applySum);

				$('.per').html('Discount ('+pricecpn+'%)<i>-</i> <span class="discount">'+sign+applySum+'</span>')

				$('.total3').text(sign+sum1);
				$('.grand').text(sign+totalAmt1);
				$('.grandtotal').val(totalAmt1);


			}else{

				$('.total3').text(sign+sum1);
				$('.grand').text(sign+sum1);
				$('.grandtotal').val(sum1);
			}
		// working on on click 
		$('.inc').click(function(){
			// for loop
			var sum = 0;
			$('.kk').each(function(){
				var id = $(this).attr('data');
				var val = $(this).val();
				var price = $('.product_price_'+id).attr('data-price');

				
				var actprice= val*price;
				var allcur= "<?=currency("");?>";
				

				if(allcur=='DKK0.00'){
					var sign = 'DKK';
				}else{
					var sign = '€';
				}
				
				var actprice1= actprice.toFixed(2); 
				$('.pp_'+id).text(sign+actprice1);
				
				 
				sum += Number(actprice);
						
			});

				var allcur= "<?=currency("");?>";
				

				if(allcur=='DKK0.00'){
					var sign = 'DKK';
				}else{
					var sign = '€';
				}

			 var sum1= sum.toFixed(2);
			  
			var cpntype= "{{$cpnData->cpn_type}}";
			//alert(cpntype);
			if(cpntype=='fixed'){
				var pricecpn="{{number_format($cpnData->cpn_price/euro()->conversion)}}";
				var applySum= sum1-pricecpn;
				//alert(applySum);

				$('.discount').text(sign+pricecpn);
				$('.total3').text(sign+sum1);
				$('.grand').text(sign+applySum);
				$('.grandtotal').val(applySum);
			}else if(cpntype=='percent'){
				var pricecpn="{{$cpnData->cpn_price}}";
				var applySum= sum1*pricecpn/100;
				var totalAmt1= sum1-applySum;
				 
				//$('.discount').text(sign+applySum);

				$('.per').html('Discount ('+pricecpn+'%)<i>-</i> <span class="discount">'+sign+applySum+'</span>')

				$('.total3').text(sign+sum1);
				$('.grand').text(sign+totalAmt1);
				$('.grandtotal').val(totalAmt1);


			}else{

				$('.total3').text(sign+sum1);
				$('.grand').text(sign+sum1);
				$('.grandtotal').val(sum1);
			}
		});

		// update cart Qty
		$('.kk').click(function(){
			var id= $(this).attr('data-productid');
			var inputValue= $(this).val();
			var totalProdQty= $(this).attr('data-qty');
			
			 
			
			if(parseInt(inputValue) > parseInt(totalProdQty)){
			    return false;
			}
			
			$.ajax({
				url:"{{url('/post-cart')}}",
				method:'post',
				data:{'_token':"{{csrf_token()}}",'id':id,'qty':inputValue},
				success:function(result){
					$('.alert').css('display','block').delay(3000).fadeOut(800);
				}
			});
		});




	});

	</script>
<!--  -->
@endsection