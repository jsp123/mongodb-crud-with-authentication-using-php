<!DOCTYPE html>
<html lang="en">
<head>
	<title>MongoDB CRUD wtih Authentication Example</title>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">
	<link rel="stylesheet" href="css/lobibox.min.css">
	<link rel="stylesheet" href="css/styles.css">
</head>
<body class="override">
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">MongoDB CRUD with Auth Example</a>
			</div>
			
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="products.php">Products</a></li>
					<?php if( ! is_user_logged_in() ): ?>
						<li><a href="user-register.php">Register</a></li>
						<li><a href="user-login.php">Login</a></li>
					<?php else: ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dashboard <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="user-account.php">Account</a></li>
								<li><a href="user-products.php">Manage Products</a></li>
							</ul>
						</li>
						<li><a href="user-logout.php">Logout</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>