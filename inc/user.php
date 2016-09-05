<?php 
/**
 * User Model 
 *
 * @author		Carl Victor Fontanos
 * @author_url	www.carlofontanos.com
 *
 */

function register( $user_data ) {
	
	global $users;
	
	$user_data['password'] = md5( $user_data['password'] );	
	$users->insert( $user_data );
	
	login( $user_data['email'], $user_data['password'], 'user-account.php' );
		
	return true;
}

function check_login( $email, $password ) {
	
	global $users;
	
	$correct_password = $users->findOne( array(
		'email' 	=> $email, 
		'password' 	=> md5( $password ) 
	) );
	
	return $correct_password ? true : false;
}

function email_exists(){
	
	global $users;
	
	$query = $users->findOne( array(
		'email' => $_POST['email']
	) );
	
	return $query ? true : false;
}

function login( $email, $password, $redirect = '' ) {
	
	$_SESSION['email'] = $email;
	$_SESSION['password'] = $password;
	$_SESSION['loggedIn'] = true;
	
	if( $redirect ){
		header('Location: ' . $redirect );
	}
	
	return true;
}

function logout() {
	
	unset( $_SESSION['email'] );
	unset( $_SESSION['password'] );
	unset( $_SESSION['loggedIn'] );
	
	session_destroy();
	
	return true;
}

function is_user_logged_in() {
	return isset( $_SESSION['loggedIn'] ) ? true : false;
}

function current_user(){
	
	global $users;
	
	if( ! is_user_logged_in() ){
		return false;
	}
	
	$current_user_data = $users->findOne( array(
		'email' => $_SESSION['email']
	) );
	
	return (object) $current_user_data;
}

function update_account( $id, $data ){
	
	global $users; 
	
	/* Check if object ID is valid */
	if( MongoId::isValid( $id ) == true ){
		
		/* Update our fields from the database */
		$users->update(
			array( '_id' => new MongoId( $id ) ),
			array( '$set' => $data )
		);
		
		/* Check if the update was successfull */
		return $users->findOne() ? true : false;
		
	} else {
		echo false;
	}
}

?>
