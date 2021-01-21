@extends('webpanel.layouts.front-layout')
@section('title')
Shipping Policy
@stop
@section('content')
<?php error_reporting(0)?>
 <!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="{{url('/products')}}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Shipping Policy</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- checkout -->
	<style type="text/css">
		.h3, h3 {
    font-size: 24px;
    padding: 15px;
}
p {
    margin: 0;
    padding: 19px;
}
b, strong {
    font-weight: 700;
    padding: 16px;
}
	</style>
 	<div class="checkout1">
		<div class="container">
			<div class="text">
			  <p>Moretti Milano ("we" and "us") is the operator of (https://shop.morettimilano.com) ("Website"). By placing an order through this Website you will be agreeing to the terms below. These are provided to ensure both parties are aware of and agree upon this arrangement to mutually protect and set expectations on our service.</p>

			  <h3>1. General</h3>

			  <p>Subject to stock availability. We try to maintain accurate stock counts on our website but from time-to-time there may be a stock discrepancy and we will not be able to fulfill all your items at time of purchase. In this instance, we will fulfill the available products to you, and contact you about whether you would prefer to await restocking of the backordered item or if you would prefer for us to process a refund.</p>

			  <h3>2. Shipping Costs</h3>
			  <p>Shipping is Free.</p>
			  <h3>3. Returns</h3>
			  <b>3.1 Return Due To Change Of Mind</b>
			  <p>Moretti Milano will happily accept returns due to change of mind as long as a request to return is received by us within 15 days of receipt of item and are returned to us in original packaging, unused and in resellable condition.<br>Return shipping will be paid at the customers expense and will be required to arrange their own shipping.<br>Once returns are received and accepted, refunds will be processed to store credit for a future purchase. We will notify you once this has been completed through email.<br>(Moretti Milano) will refund the value of the goods returned but will NOT refund the value of any shipping paid.</p>
			  <b>3.2 Warranty Returns</b>
			  <p>Moretti Milano will happily honor any valid warranty claims, provided a claim is submitted within 90 days of receipt of items.<br>Customers will be required to pre-pay the return shipping, however we will reimburse you upon successful warranty claim.<br>Upon return receipt of items for warranty claim, you can expect Moretti Millano to process your warranty claim within 7 days.
			  	<br><br>
			  	Once warranty claim is confirmed, you will receive the choice of:<br><br>
			  	(a) refund to your payment method<br><br>
			  	(b) a refund in store credit<br><br>
			  	(c) a replacement item sent to you (if stock is available)
			  </p>
			  <b>3.2 Warranty Returns</b>
			  <p>Moretti Milano will happily honor any valid warranty claims, provided a claim is submitted within 90 days of receipt of items.
			  	<br>Customers will be required to pre-pay the return shipping, however we will reimburse you upon successful warranty claim.<br>Upon return receipt of items for warranty claim, you can expect Moretti Millano to process your warranty claim within 7 days.<br><br>
			  	Once warranty claim is confirmed, you will receive the choice of:<br><br>
			  	(a) refund to your payment method<br><br>
			  	(b) a refund in store credit<br><br>
			  	(c) a replacement item sent to you (if stock is available)

			  </p>
			  <h3>4. Delivery Terms</h3>
			  <b>4.1 Transit Time Domestically</b>
			  <p>In general, domestic shipments are in transit for 2 - 7 days</p>
			  <b>4.2 Transit time Internationally</b>
			  <p>Generally, orders shipped internationally are in transit for 4 - 22 days. This varies greatly depending on the courier you have selected. We are able to offer a more specific estimate when you are choosing your courier at checkout.</p>
			  <b>4.3 Dispatch Time</b>
			  <p>Orders are usually dispatched within 2 business days of payment of order
			  	<br>Our warehouse operates on Monday - Friday during standard business hours, except on national holidays at which time the warehouse will be closed. In these instances, we take steps to ensure shipment delays will be kept to a minimum.</p>

			  	<b>4.4 Change Of Delivery Address</b>
			  	<p>For change of delivery address requests, we are able to change the address at any time before the order has been dispatched.</p>
			  	<b>4.5 P.O. Box Shipping</b>
			  	<p>Moretti Milano will ship to P.O. box addresses using postal services only. We are unable to offer couriers services to these locations.</p>
			  	<b>4.6 Items Out Of Stock</b>
			  	<p>If an item is out of stock, we will dispatch the in-stock items immediately and send the remaining items once they return to stock.</p>
			  	<b>4.7 Delivery Time Exceeded</b>
			  	<p>If delivery time has exceeded the forecasted time, please contact us so that we can conduct an investigation.</p>
			  	<h3>5. Tracking Notifications</h3>
			  	<p>Upon dispatch, customers will receive a tracking link from which they will be able to follow the progress of their shipment based on the latest updates made available by the shipping provider.</p>
			  	<h3>6. Parcels Damaged In Transit</h3>
			  	<p>If you find a parcel is damaged in-transit, if possible, please reject the parcel from the courier and get in touch with our customer service. If the parcel has been delivered without you being present, please contact customer service with next steps.</p>
			  	<h3>7. Duties & Taxes</h3>
			  	<b>7.1 Sales Tax</b>
			  	<p>Sales tax has already been applied to the price of the goods as displayed on the website</p>
			  	<b>7.2 Import Duties & Taxes</b>
			  	<p>Import duties and taxes for international shipments will be pre-paid, without any additional fees to be paid by customer upon arrival in destination country </p>
			  	<h3>8. Cancellations</h3>
			  	<p>If you change your mind before you have received your order, we are able to accept cancellations at any time before the order has been dispatched. If an order has already been dispatched, please refer to our refund policy.</p>
			  	<h3>9. Insurance</h3>
			  	<p>Parcels are insured for loss and damage up to the value as stated by the courier.</p>
			  	<b>9.1 Process for parcel damaged in-transit</b>
			  	<p>We will process a refund or replacement as soon as the courier has completed their investigation into the claim.</p>
			  	<h3>9.2 Process for parcel lost in-transit</h3>
			  	<p>We will process a refund or replacement as soon as the courier has conducted an investigation and deemed the parcel lost.</p>
			  	<h3>10. Customer service</h3>
			  	<p>For all customer service enquiries, please email us at <a href="mailto:info@morettimilano.com">info@morettimilano.com</a> Or call +4522323640</p>
			</div>

		</div>
	</div>

@endsection