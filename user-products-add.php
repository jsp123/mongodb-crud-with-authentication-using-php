<?php require_once('inc/config.php'); ?>
<?php require_once('partials/header.php'); ?>

<div class="container">
	<p class="ml-b"><a href = "user-products.php" class="ml-b text-success"><span class="glyphicon glyphicon-chevron-left"></span> All products</a></p>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			Add Product
		</div>
		<div class="panel-body">
			<form method="post" action="inc/ajax/products/update.php" class="create-product">
				<div class="col-md-8">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="name" value="" />
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea id="ck-editor-area" class="form-control" name="content"></textarea>
					</div>
					<div class="form-group">
						<label>Short Description</label>
						<textarea class="form-control" name="excerpt" rows="7"></textarea>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Price</label>
						<div class="input-group">
							<div class="input-group-addon">$</div>
							<input type="text" class="form-control" name="price" value="" placeholder="Amount">
						</div>
					</div>
					<div class="form-group">
						<label>Status</label>
						<select class="form-control" name="status">
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
					<div class="form-group">
						<label>Date</label>
						<div class='input-group date datepicker'>
							<input type='text' class="form-control" name="date" value="" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label>Quantity</label>
						<input type="number" class="form-control" name="quantity" value="" />
					</div>
					<input type="submit" class="btn btn-success" value="Update" />
				</div>
			</form>
		</div>
	</div>
</div>

<?php require_once('partials/footer.php'); ?>