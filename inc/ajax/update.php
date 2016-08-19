<?php 
require_once('../config.php');

$collection = $db->posts;

if( isset( $_POST['item_id'] ) ){
	
	$update_item = $collection->update(
		array(
			'_id' 			=> new MongoId( $_POST['item_id'] )
		),
		array('$set' => 
			array(
				'content'	=> $_POST['ticket'],
				'category'	=> $_POST['category'],
				'test1'		=> $_POST['tags'],
				'test2'		=> $_POST['excerpt']
			)
		)
	);
	
	echo $update_item == 1 ? $update_item : 0;
}