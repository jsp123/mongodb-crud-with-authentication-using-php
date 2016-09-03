<?php require_once('inc/config.php'); ?>
<?php require_once("partials/header.php"); ?>
<?php 
if( is_user_logged_in() ){
	header('Location: user-account.php');
}

$error_message = '';

if( isset( $_POST['email'] ) ) {
	/* Let's make email and password required fields */
	if( empty( $_POST['email'] ) || empty( $_POST['password'] ) ){
		$error_message = 'Email and Password is required';
		
	/* Validate the email */
	} else if( ! filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) === true ){
		$error_message = 'Invalid email entered';
		
	/* Check if both entered password match each other */
	} else if( ! ( $_POST['password'] == $_POST['password2'] ) ) {
		$error_message = 'Your passwords did not match';
		
	/* Check if we already have an existing email in our user table */	
	} else if( email_exists( $_POST['email'] ) ) {
		$error_message = 'Email already exists, please choose another email';	
		
	/* All validations completed, let's submit our data */	
	} else {
		$post_array = array();
		/* Store an array of post data whose values are not empty */
		/* This makes it easier to scale our fields */
		foreach( $_POST as $key => $value ){
			if( ! empty( $_POST[$key] ) && $_POST[$key] != 'password2' ){
				$post_array[$key] = $_POST[$key];
			}
		}
		register( $post_array );
	}
}
?>

<div class="container">
	<form action="" method="post">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Register</div>
				<div class="panel-body">
					<?php if( ! empty( $error_message ) ): ?>
						<p class="bg-danger p-d ml-b"><?php echo $error_message; ?></p>
					<?php endif; ?>
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">Email<span class="text-red">*</span>:</label>
						<div class="col-md-6">
							<input type="text" name="email" value="<?php echo isset( $_POST['email'] ) ? $_POST['email'] : ''; ?>" class="form-control">
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">Password<span class="text-red">*</span>:</label>
						<div class="col-md-6">
							<input type="password" name="password" value="<?php echo isset( $_POST['password'] ) ? $_POST['password'] : ''; ?>" class="form-control" />
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">Confirm password:</label>
						<div class="col-md-6">
							<input type="password" name="password2" value="<?php echo isset( $_POST['password2'] ) ? $_POST['password2'] : ''; ?>" class="form-control" />
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">First Name:</label>
						<div class="col-md-6">
							<input type="first_name" name="first_name" value="<?php echo isset( $_POST['first_name'] ) ? $_POST['first_name'] : ''; ?>" class="form-control" />
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">Last Name:</label>
						<div class="col-md-6">
							<input type="last_name" name="last_name" value="<?php echo isset( $_POST['last_name'] ) ? $_POST['last_name'] : ''; ?>" class="form-control" />
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">Phone Number:</label>
						<div class="col-md-6">
							<input type="phone_number" name="phone_number" value="<?php echo isset( $_POST['phone_number'] ) ? $_POST['phone_number'] : ''; ?>" class="form-control" />
						</div>
					</div>
					<div class="col-md-6 col-md-offset-4">
						<input type="submit" value="Register" class="btn btn-success">
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<?php require_once("partials/footer.php"); ?>