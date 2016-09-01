<?php 
require_once('../../config.php');

if( isset( $_POST['name'] ) ){
	
	$post_fields_array = array();
	
	$valid_formats = array('jpg', 'png', 'gif', 'bmp', 'jpeg'); /* Supported file types */
    $max_file_size = 1024 * 500; /* in kb */
	$path = ABSPATH . '/img/uploads/'; /* path to where we will be saving the images */
	$images = array();
	
	if( isset( $_FILES['files'] ) && ! empty( $_FILES['files'] ) ) { 
		foreach ( $_FILES['files']['name'] as $f => $name ) {
			$extension = pathinfo( $name, PATHINFO_EXTENSION );
			/* Generate a randon code for each file name */
			$new_filename = generate_random_code( 20 )  . '.' . $extension;
			
			if ( $_FILES['files']['error'][$f] == 4 ) {
				continue; 
			}
			
			if ( $_FILES['files']['error'][$f] == 0 ) {
				/* Check if image size is larger than the allowed file size */
				if ( $_FILES['files']['size'][$f] > $max_file_size ) {
					$upload_message[] = $name . 'is too large!.';
					continue;
				
				/* Check if the file being uploaded is in the allowed file types */
				} elseif( ! in_array( strtolower( $extension ), $valid_formats ) ){
					$upload_message[] = $name . 'is not a valid format';
					continue; 
				
				} else{ 
					/* If no errors, upload the file */
					if( move_uploaded_file( $_FILES["files"]["tmp_name"][$f], $path . $new_filename ) ) {
						/* */
						$images[] = $new_filename;
					}
				}
			}
		}
	}
	
	/* Let's build an array out of available values that are posted */
	foreach( $_POST as $key => $value ){
		if( $key != 'images'){
			$post_fields_array[$key] = $_POST[$key];
		}
	}
	
	$post_fields_array['images'] = $images;
	
	echo add_product( $post_fields_array ) ? 1 : 0;
	
} else {
	echo 0;
}