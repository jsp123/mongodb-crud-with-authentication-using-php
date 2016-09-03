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
		login( $_POST['email'], $_POST['password'], 'user-account.php' );
	}
}
?>

<div class="container">
	<form name="form1" method="post">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
				<div class="panel-body">
					<?php if( ! empty( $error_message ) ): ?>
						<p class="bg-danger p-d ml-b"><?php echo $error_message; ?></p>
					<?php endif; ?>
					<div class="form-group clearfix">
						<label for="email" class="col-md-4 control-label text-right">Email:</label>
						<div class="col-md-6">
							<input name="email" value="<?php echo isset( $_POST['email'] ) ? $_POST['email'] : '' ; ?>" type="text" class="form-control" />
						</div>
					</div>
					<div class="form-group clearfix">
						<label for="password" class="col-md-4 control-label text-right">Password:</label>
						<div class="col-md-6">
							<input name="password" type="password" class="form-control" />
						</div>
					</div>
					<div class="col-md-6 col-md-offset-4">
						<input name="login" type="submit" value="Login" class="btn btn-success" />
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<?php require_once("partials/footer.php"); ?>
