<?php 
require_once('../../config.php');

if( isset( $_POST['item_id'] ) ){
	
	$post_fields_array = array();
	
	/* Let's build an array out of available values that are posted */
	foreach( $_POST as $key => $value ){
		$post_fields_array[$key] = $_POST[$key];
	}
	
	echo update_product( $_POST['item_id'], $post_fields_array ) ? 1 : 0;
	
} else {
	echo 0;
}