<?php 
require_once('../../config.php');

$err_succ = array(
	'status' => 0,
	'message' => '',
);

if( isset( $_POST['action'] ) && $_POST['action'] == 'unset-image' ){
	
	$image_path = ABSPATH . '/img/uploads/' . $_POST['image'];
	
	if( file_exists( $image_path ) == true && unlink( $image_path ) ){
		$err_succ['status'] = unset_image( $_POST['item_id'], $_POST['image'] ) ? 1 : 0;
		$err_succ['message'] = 'Image successfully deleted';
		
	} else {
		$err_succ['message'] = 'Delete failed, please try again';
	}
	
} 

if( isset( $_POST['action'] ) && $_POST['action'] == 'set-featured-image' ){

	if( set_featured_image( $_POST['item_id'], $_POST['image'] ) ){
		$err_succ['status'] = 1;
		$err_succ['message'] = 'Image successfully set as featured';
	
	} else {
		$err_succ['message'] = 'Failed, please try again';
	} 
}

echo json_encode( $err_succ );