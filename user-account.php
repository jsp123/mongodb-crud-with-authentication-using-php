<?php 
	require_once('inc/config.php');
	
	if( ! is_user_logged_in() ){
		header('Location: user-login.php');
		exit();
	}
	
	require_once('partials/header.php'); 
?>

<div class="container wave-box-wrapper">
	<div class="wave-box"></div>
	<form action="inc/ajax/user/update.php" method="post" class="update-account">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">My Account</div>
				<div class="panel-body">
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">Email<span class="text-red"></span>:</label>
						<div class="col-md-6">
							<input type="text" name="email" value="<?php echo $current_user->email; ?>" class="form-control" disabled>
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">Old password:</label>
						<div class="col-md-6">
							<input type="password" name="old_password" value="" class="form-control" />
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">New password:</label>
						<div class="col-md-6">
							<input type="password" name="password" value="" class="form-control" />
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">Confirm New password:</label>
						<div class="col-md-6">
							<input type="password" name="password_confirm" value="" class="form-control" />
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">First Name:</label>
						<div class="col-md-6">
							<input type="first_name" name="first_name" value="<?php echo $current_user->first_name; ?>" class="form-control" />
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">Last Name:</label>
						<div class="col-md-6">
							<input type="last_name" name="last_name" value="<?php echo $current_user->last_name; ?>" class="form-control" />
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">Phone Number:</label>
						<div class="col-md-6">
							<input type="phone_number" name="phone_number" value="<?php echo $current_user->phone_number; ?>" class="form-control" />
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-md-4 control-label text-right">About Me:</label>
						<div class="col-md-6">
							<textarea name="about_me" id="ck-editor-area" class="form-control"><?php echo isset( $current_user->about_me ) ? $current_user->about_me : ''; ?></textarea>
						</div>
					</div>
					<div class="col-md-6 col-md-offset-4">
						<input type="hidden" name="user_id" value="<?php echo $current_user->_id; ?>" />
						<input type="submit" value="Update" class="btn btn-success">
					</div>
				</div>
			</div>
		</div>
	</form>
</div>


<?php require_once('partials/footer.php'); ?>
