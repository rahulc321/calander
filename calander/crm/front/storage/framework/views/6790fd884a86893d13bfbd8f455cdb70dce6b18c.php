<?php $__env->startSection('title'); ?>
Order History
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php error_reporting(0); ?>
 <!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="<?php echo e(url('/')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Order History</li>
				<li style="float:right"><a href="<?php echo e(url('/edit-profile')); ?>">Edit Profile</a></li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- checkout -->

 	<div class="checkout">

		<div class="container">

			<div class="checkout-right animated wow slideInUp" data-wow-delay=".5s">
				<table class="timetable_sub">
					<thead>
						<tr>
							<th>Sr No.</th>	
							<th>Order Id</th>	
							<th>Product</th>
							<th>Qty</th>
							<th>Product Name</th>
							<th>Product Color</th>
							<th>Product Price</th>
							<th>Total Price</th>
							<th>Order Status</th>
							<th>Order Date</th>
							 
						</tr>
					</thead>

					<?php
					$i=1;
					?>
					<?php foreach($order as $allOrder): ?>
					<?php $items = $allOrder->items()->with('product.photos')->get(); $grandTotal = 0; ?>
                	<?php foreach($items as $item): ?>

                	<?php
                	 // echo '<pre>';print_r($item['product']['photos'][0]['media']['filename']);
                    if(isset($item['product']['photos'][0]['media']['filename'])){
                	$fileName= $item['product']['photos'][0]['media']['filename'];
                	$folder= $item['product']['photos'][0]['media']['folder'];
                    }
                	?>
					<tr class="rem1">
						<td class="invert"><?=$i?></td>
						<td class="invert"><?php echo e($allOrder->OID); ?></td>
						<td class="invert-image"><img src="<?php echo e(url('/')); ?>/public/<?php echo e($folder.$fileName); ?>" alt=" " class="img-responsive" style="width: 56px;" onerror='this.onerror=null;this.src="<?php echo NO_IMG; ?>"'/></td>
						<td class="invert">
							 <div class="quantity"> 
								<div class="quantity-select">    <center>                       
									<?php echo e($item->qty); ?>

								</center>
								</div>
							</div>
						</td>
						<td class="invert"><?php echo e(@$item->product->name); ?></td>
						<td><?php echo e(@$item->variant->color->name); ?></td>
						<td class="invert product_price_<?=$i?>" data-price="<?php echo e($item->product->price); ?>"><?php echo e(currency($item->price)); ?></td>
						<td class="invert product_price_<?=$i?>" data-price="<?php echo e($item->product->price); ?>"><?php echo e(currency($item->price * $item->qty )); ?></td>
						 
						<td class="invert">
						
							<span class="pp_<?=$i?>"><?php echo @\App\Modules\Orders\Order::$statusLabel[$allOrder->status]; ?></span>
						</td>
						<td class="invert">
							
							<span class="pp_<?=$i?>"><?php echo e($allOrder->createdDate('d/m/Y')); ?></span>
						</td>
						 
					</tr>

					<?php $i++;?>
					 <?php endforeach; ?>
					  <?php endforeach; ?>
				</table>
				<?php echo e($orders1->render()); ?>


			</div>
 
				<div class="clearfix"> </div>
			</div>
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
			 
			$('.total3').text(' '+sum);
			$('.grand').text(' '+sum);
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
				$('.pp_'+id).text('DKK '+actprice);
				
				 
				sum += Number(actprice);
						
			});
			  
			$('.total3').text(' '+sum);
			$('.grand').text(' '+sum);
		});

		// update cart Qty
		$('.kk').click(function(){
			var id= $(this).attr('data-productid');
			var inputValue= $(this).val();
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