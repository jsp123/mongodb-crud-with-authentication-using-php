<?php 
require_once('../config.php');

$collection = $db->products;

/* Check if we received an object ID and that if it's valid */
if( isset( $_POST['item_id'] ) && MongoId::isValid( $_POST['item_id'] ) == true ){
	
	$post_fields_array = array();
	
	/* Let's build an array out of available values that are posted */
	foreach( $_POST as $key => $value ){
		$post_fields_array[$key] = $_POST[$key];
	}
	
	/* Update our fields from the database */
	$update_item = $collection->update(
		array( '_id' => new MongoId( $_POST['item_id'] ) ),
		array( '$set' => $post_fields_array )
	);
	
	/* Check if the insert was successfull */
	echo $collection->findOne() ? 1 : 0;
	
} else {
	echo 0;
}