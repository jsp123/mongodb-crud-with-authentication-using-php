<?php

require_once('../config.php');

/* Check if we received an object ID and that if it's valid */
if( isset( $_POST['item_id'] ) && MongoId::isValid( $_POST['item_id'] ) == true ){
	$remove = $products->remove( 
		array( '_id' => new MongoID( $_POST['item_id'] ) ) 
	);
	
	echo $remove ? 1 : 0;
	
} else {
	echo 0;
}
