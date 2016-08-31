<?php require_once('inc/config.php'); ?>
<?php require_once('partials/header.php'); ?>
<?php 
if( is_user_logged_in() ){
	header('Location: account.php');
}

$error_message = '';

if( isset( $_POST['login'] ) ) {
	/* Make email and password required fields */
	if( empty( $_POST['email'] ) || empty( $_POST['password'] ) ){
		$error_message = 'Please enter your email or password';
	
	/* Validate provided login information */
	} else if( ! check_login( $_POST['email'], $_POST['password'] ) ){
		$error_message = 'Incorrect email or password';
	
	/* All validations completed, let's login the user */
	} else {
		login( $_POST['email'], $_POST['password'], 'account.php' );
	}
}
?>

<div class="container">
	<div class="col-md-6">
		<?php if( ! empty( $error_message ) ): ?>
			<p class="bg-danger p-d ml-b"><?php echo $error_message; ?></p>
		<?php endif; ?>
		<form name="form1" method="post">
			<div class="form-group">
				<label for="email">Email:</label>
				<input name="email" value="<?php echo isset( $_POST['email'] ) ? $_POST['email'] : '' ; ?>" type="text" class="form-control" />
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input name="password" type="password" class="form-control" />
			</div>
			<input name="login" type="submit" value="Login" class="btn btn-success" />
		</form>
	</div>
</div>

<?php require_once("partials/footer.php"); ?>
