<?php 

require_once('inc/config.php');

// Create a "collection" (in MYSQL we call it "table") called "posts"
$collection = $db->products;

// Create a "document" (in MySQL we call it rows)

for( $i = 1; $i <= 500; $i++ ){
	if( $i <= 100 ){
		$price = '5.75';
		$status = '1';
		$quantity = '1';
	} else if( $i <= 200 && $i > 100 ){
		$price = '10.50';
		$status = '0';
		$quantity = '2';
	} else if($i <= 300 && $i > 200 ){
		$price = '15.00';
		$status = '1';
		$quantity = '4';
	} else if( $i <= 400 && $i > 300 ){
		$price = '20.00';
		$status = '0';
		$quantity = '6';
	} else if( $i <= 500 && $i > 400 ){
		$price = '25.25';
		$status = '1';
		$quantity = '10';
	}
	
	$doc = array(
		'name' 		=> 'Product ' . $i,
		'price' 	=> $price,
		'status' 	=> $status,
		'date' 		=> date("Y-m-d H:i:s", time()),
		'quantity' 	=> $quantity
	);
	$collection->insert($doc);
}

// $collection->drop();