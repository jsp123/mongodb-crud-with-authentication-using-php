<?php 
require_once('../../config.php');

$err_succ = array(
	'status'	=>	0,
	'message'	=>	''
);
		
if( isset( $_POST['item_id'] ) ){
	
	$post_fields_array = array();
	$set_images = array('errors' => '', 'images' => '');
	
	$valid_formats = array('jpg', 'png', 'gif', 'bmp', 'jpeg'); /* Supported file types */
    $max_file_size = 1024 * 500; /* in kb */
	$path = ABSPATH . 'img/uploads/'; /* path to where we will be saving the images */
	$images = array();
	
	if( isset( $_FILES['images'] ) && ! empty( $_FILES['images'] ) ) {
		foreach ( $_FILES['images']['name'] as $f => $name ) {
			$extension = pathinfo( $name, PATHINFO_EXTENSION );
			/* Generate a randon code for each file name */
			$new_filename = generate_random_code( 20 )  . '.' . $extension;
			
			if ( $_FILES['images']['error'][$f] == 4 ) {
				continue; 
			}
			
			if ( $_FILES['images']['error'][$f] == 0 ) {
				/* Check if image size is larger than the allowed file size */
				if ( $_FILES['images']['size'][$f] > $max_file_size ) {
					$set_images['errors'][] = $name . 'is too large!.';
					continue;
				
				/* Check if the file being uploaded is in the allowed file types */
				} elseif( ! in_array( strtolower( $extension ), $valid_formats ) ){
					$set_images['errors'][] = $name . 'is not a valid format';
					continue; 
				
				} else{ 
					/* If no errors, upload the file */
					if( move_uploaded_file( $_FILES["images"]["tmp_name"][$f], $path . $new_filename ) ) {
						/* */
						$set_images['images'][] = $new_filename;
						
					}
				}
			}
		}
	}
	
	/* Let's build an array out of available values that are posted */
	foreach( $_POST as $key => $value ){
		if( $key != 'images' ){
			$post_fields_array[$key] = $_POST[$key];
		}
	}
	
	if( ! update_product( $_POST['item_id'], $post_fields_array ) ){
		$err_succ['status'] = 0;
		$err_succ['message'] = 'Update failed, please try again';

	} elseif( $set_images['errors'] ) {
		$err_succ['status'] = 0;
		$err_succ['errors'] = $set_images['errors'];
		$err_succ['images'] = $set_images['images'];
		
	} else {
		if( $set_images['images'] ){
			/* Insert images to the database */
			foreach( $set_images['images'] as $image ){
				add_image( $_POST['item_id'], $image );
			}
		}
		
		$err_succ['status'] = 1;
		$err_succ['message'] = 'Item successfully updated!';
		$err_succ['images'] = $set_images['images'];
	}
	
} else {
	$err_succ['message'] = 'Empty ID submitted';
}

echo json_encode( $err_succ );
// echo '<pre>';
// print_r( $_FILES );
// echo '</pre>';