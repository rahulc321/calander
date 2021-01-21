<?php $__env->startSection('title'); ?>
Cart
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php error_reporting(0)?>
 <!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="<?php echo e(url('/products')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Checkout Page</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- checkout -->

 	<div class="checkout">
		<div class="container">
			<p class="alert alert-info" style="display:none">You have Successfully Updated Cart <img src="<?php echo e(Request::root()); ?>/public/front/images/bag.png" alt="" /></p>

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
			<?php echo e($totalItems); ?> Products</span></h3>
			<?php if($totalItems > 0): ?>
			<span style="float:right"> 
                <small style="color: #d8703f;">ORDER ID: <?php echo e($order->OID); ?></small>
            </span>
            <div class="range" style="color: #d8703f;">
            Order Date: <?php echo e($order->createdDate()); ?><br>
           
            
        	</div>
        	<?php endif; ?>
        	<?php if(!$order || $totalItems == 0): ?>

            <div class="callout callout-danger" style="margin: 0;">
                <h5><i class="icon-cart-add"></i><img src="<?php echo e(Request::root()); ?>/public/front/images/bag.png" alt="" /> No Items in a cart</h5>
                <p>No items in cart. Please add new items first. <a href="<?php echo e(url('/')); ?>">Click
                        here</a> to add item.</p>
            </div>

        <?php else: ?>


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
                	<?php foreach($items as $k => $item): ?>

                	<?php
                	// echo '<pre>';print_r($item['product']['photos'][0]['media']['filename']);
                    if(isset($item['product']['photos'][0]['media']['folder']))
                	$folder= $item['product']['photos'][0]['media']['folder'];
					$fileName= $item['product']['photos'][0]['media']['filename'];
                     // echo '<pre>';print_r($item);die;
                	?>

					<tr class="rem1">
						<td class="invert">1</td>
						<td class="invert-image"><img src="<?php echo e(url('/')); ?>/public/<?php echo e($folder.$fileName); ?>" alt=" " class="img-responsive" style="width: 56px;" onerror='this.onerror=null;this.src="<?php echo NO_IMG; ?>"'/></td>
						<td class="invert">
							 <div class="quantity"> 
								<div class="quantity-select">    <center>                       
									<input type="number" class="form-control inc kk" name="qty" value="<?php echo e($item->qty); ?>" min="1" max="<?php echo e($variantData['qty']); ?>" data-qty="<?php echo e($variantData['qty']); ?>" style="width: 123px;"  data="<?=$i?>" data-productid='<?php echo e($item->id); ?>'>
								</center>
								</div>
							</div>
						</td>
						<td class="invert"><?php echo e(@$item->product->name); ?></td>
						<td><?php echo e(@$item->variant->color->name); ?></td>
						<td class="invert product_price_<?=$i?>" data-price="<?php echo e($item['product']['web_shop_price']); ?>"> <?php if($item['product']['web_shop_price'] !=0): ?>
                            <?php echo e(currency($item['product']['web_shop_price'])); ?>

                         <?php else: ?>
                            <?php echo e(currency($item['product']['price'])); ?>

                         <?php endif; ?>
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
							<input type="hidden" class="perProductPrice_<?=$i?>" value="<?=$totalPrice?>">
							<span class="pp_<?=$i?>"><?=currency($totalPrice)?></span>
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
					 <?php endforeach; ?>
				</table>
			</div>

			
			


			<div class="checkout-left">	
				<div class="checkout-left-basket animated wow slideInLeft" data-wow-delay=".5s">
					<h4>Continue to basket</h4>
					<ul>
						<li>Total <i>-</i> <span class="total3"></span></li>
						
						 
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
			<div class="process" style="float:right;margin-top: 44px;">
					<!-- <a class="btn btn-warning btn-sm" href="<?php echo e(url('/orders/place/xl')); ?>">Place Order</a> -->
					<div id="paypal-button-container"></div>
				</div>
			 
				<?php endif; ?>

		</div>
	</div>
	<style type="text/css">
		.callout-danger {
		background-color: #fdf7f7;
		border-color: #D65C4F !important;
		}
		.callout {
		margin: 0 0 35px 0;
		padding: 20px;
		border-left: 3px solid #eee;
		}

		.checkout-left-basket h4 {
   
    	background: #2f8441 !important;
		}
		.checkout-left-basket {
    	float: right !important;
 		}
	</style>
<!-- //checkout -->

<?php
	
	if(currency("")=='DKK0.00'){
		$sign = 'DKK';
	}else{
		$sign = 'EUR';
	}
 
?>
<!-- paypal -->
<script src="https://www.paypal.com/sdk/js?client-id=ATrvvkM9mwRMXp2ZUbEpRXpNVRv8M-KBdLLx8-803Gr2N9N5_NwxBVDmkd6yYf6P91PtEnfOXROC_xM1&currency=<?=$sign?>"></script>
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
                			url:"<?php echo e(url('/paypal-transaction')); ?>",
                			method:'post',
                			data:{'_token':"<?php echo e(csrf_token()); ?>",'paymentStatus':paymentStatus,'transactionId':transactionId,'currency':currency,'amount':amount},
                			success:function(result){
                				// window.location.replace("<?php echo e(url('/orders/place/xl')); ?>");
                				//alert(result)

								Swal.fire({
								type: 'success',
								title: 'Success...',
								text: 'Congratulations !! Your Payment has been Received.',
								timer: 3000
								})
                				 window.location.replace("http://morettimilano.com/front/front/orders/place/xl");
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
		$(document).ready(function(){
		// working on onload
		 
		//alert(localStorage.name1);
		//localStorage.clear()
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
			 
			$('.total3').text(sign+sum);
			$('.grand').text(sign+sum);
			$('.grandtotal').val(sum);
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
				$('.pp_'+id).text(sign+actprice);
				
				 
				sum += Number(actprice);
						
			});

				var allcur= "<?=currency("");?>";
				

				if(allcur=='DKK0.00'){
					var sign = 'DKK';
				}else{
					var sign = '€';
				}

			  
			$('.total3').text(sign+sum);
			$('.grand').text(sign+sum);
			$('.grandtotal').val(sum);
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
				url:"<?php echo e(url('/post-cart')); ?>",
				method:'post',
				data:{'_token':"<?php echo e(csrf_token()); ?>",'id':id,'qty':inputValue},
				success:function(result){
					$('.alert').css('display','block').delay(3000).fadeOut(800);
				}
			});
		});




	});

	</script>
<!--  -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.front-layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>