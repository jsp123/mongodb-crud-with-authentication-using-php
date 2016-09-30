<?php 
require_once('../../config.php');

$err_succ = array(
	'status'	=>	0,
	'message'	=>	''
);

if( isset( $_POST['user_id'] ) ){
	
	if( isset( $_POST['old_password'] ) && ! empty( $_POST['old_password'] ) && md5( $_POST['old_password'] ) != $current_user->password ){
		$err_succ['message'] = 'Incorrect old password';
	} else {
		/* Let's build an array out of available values that are posted */
		foreach( $_POST as $key => $value ){
			if( $key != 'email' || $key != 'old_password' || $key != 'password_confirm' ){
				$post_fields_array[$key] = $_POST[$key];
				
				/*  If user does not want to change the password, let's remove all 3 password fields from the 
					set of array that we are going to pass to the update_function()
				*/
				if( empty( $_POST['old_password'] ) || empty( $_POST['new_password'] ) || empty( $_POST['password'] ) ){
					unset($post_fields_array['old_password']);
					unset($post_fields_array['new_password']);
					unset($post_fields_array['password']);
				}
			}
		}
		
		if( ! update_account( $_POST['user_id'], $post_fields_array ) ){
			$err_succ['message'] = 'Update failed';
			
		} else {
			$err_succ['status'] = 1;
			$err_succ['message'] = 'Account successfully updated';
		}
	}
	
	
} else {
	$err_succ['message'] = 'Update failed';
}

echo json_encode( $err_succ );