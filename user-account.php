<?php require_once('inc/config.php'); ?>
<?php require_once('partials/header.php'); ?>
<?php 
if( ! is_user_logged_in() ) {
	header('Location: index.php');
}

$current_user = current_user();

?>

<div class="container">
	<h1>My Account</h1>
	<ul>
		<li><strong>Email:</strong> <?php echo $current_user->email; ?></li>
		<li><strong>First Name:</strong> <?php echo $current_user->first_name; ?></li>
		<li><strong>Last Name:</strong> <?php echo $current_user->last_name; ?></li>
		<li><strong>Phone Number:</strong> <?php echo $current_user->phone_number; ?></li>
	</ul>
</div>

<?php require_once('partials/footer.php'); ?>
