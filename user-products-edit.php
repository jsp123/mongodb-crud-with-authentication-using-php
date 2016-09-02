<?php 
	require_once('inc/config.php');
	
	if( ! is_user_logged_in() ){
		header('Location: user-login.php');
		exit();
	}
	
	/* Get _id of object from the URL */
	$item_id = $_GET['id'];
	
	require_once('partials/header.php'); 
?>

<div class="container item-edit" id="item-<?php echo $item_id; ?>">
	<?php
	/* Check if we recevied a valid object id */
	if( MongoId::isValid( $item_id ) ):	
		$item = array();
		$item_data = get_product( $item_id );
		
		/* List down all known fields for our document */
		/* If you wish to add more fields, make sure to populate them here */
		/* This makes NoSQL scalability a breeze! */
		$fields = array('name', 'content', 'excerpt', 'price', 'status', 'date', 'quantity', 'images', 'featured_image'); 
		
		/* Let's check each fields if they have a matching column in our document */
		/* If the fields are not created yet, at least we could easily set a empty string as their temporary value */
		foreach( $fields as $field ){
			$item[$field] = isset( $item_data->$field ) ? $item_data->$field : '';
		}
		
		$item = (object) $item;
	?>
		<p class="ml-b"><a href = "user-products.php" class="ml-b text-success"><span class="glyphicon glyphicon-chevron-left"></span> All products</a></p>
		
		<div class="panel panel-default">
			<div class="panel-heading">
				Edit Product
			</div>
			<div class="panel-body wave-box-wrapper">
				<div class="wave-box"></div>
				<form method="post" action="inc/ajax/products/update.php" class="update-product">
					<input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
					<div class="col-md-8">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="name" value="<?php echo $item->name; ?>" />
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea id="ck-editor-area" class="form-control" name="content"><?php echo $item->content; ?></textarea>
						</div>
						<div class="form-group">
							<label>Short Description</label>
							<textarea class="form-control" name="excerpt" rows="7"><?php echo $item->excerpt; ?></textarea>
						</div>
						<div class="form-group ml-t">
							<label>Upload Images</label>
							<input type = "file" name = "images[]" accept = "image/*" class = "form-control image-input" multiple />
							<hr />
							
							<div class = "clearfix m-t images-section">
								<?php if( $item->images ): ?>
									<?php $image_count = 1; ?>
									<?php foreach( $item->images as $image ): ?>
										<div class = "col-sm-3">
											<span class="unset-image glyphicon glyphicon-remove text-danger lead m-0 c-p" id="unset-<?php echo $image; ?>" title="Delete image"></span>
											<?php if( $item->featured_image == $image ): ?>
												<span class="set-featured-image glyphicon glyphicon-star lead m-0 c-p" title="Set as featured image" id="featured-<?php echo $image; ?>" style="color: #E4C317"></span>
											<?php else: ?>
												<span class="set-featured-image glyphicon glyphicon-star-empty lead m-0 c-p" title="Set as featured image" id="featured-<?php echo $image; ?>"></span>
											<?php endif; ?>
											<img src = "img/uploads/<?php echo $image; ?>" class = "img-thumbnail img-responsive" />
										</div>
										
										<?php if( $image_count%4 == 0 ): ?>
											<div class = "clearfix"></div>
										<?php endif; ?>
										
										<?php $image_count++; ?>
									<?php endforeach; ?>
								<?php else: ?>
									<p class = "alert alert-danger no-item-images">No images found</p>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Price</label>
							<div class="input-group">
								<div class="input-group-addon">$</div>
								<input type="text" class="form-control" name="price" value="<?php echo $item->price; ?>" placeholder="Amount">
							</div>
						</div>
						<div class="form-group">
							<label>Status</label>
							<select class="form-control" name="status">
								<option value="1" <?php echo $item->status == 1 ? 'selected' : ''; ?>>Active</option>
								<option value="0" <?php echo $item->status == 0 ? 'selected' : ''; ?>>Inactive</option>
							</select>
						</div>
						<div class="form-group">
							<label>Date</label>
							<div class='input-group date datepicker'>
								<input type='text' class="form-control" name="date" value="<?php echo $item->date; ?>" />
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label>Quantity</label>
							<input type="number" class="form-control" name="quantity" value="<?php echo $item->quantity; ?>" />
						</div>
						<input type="submit" class="btn btn-success" value="Update" />
					</div>
				</form>
			</div>
		</div>
	<?php else: ?>
		<p class="bg-danger p-d">Item does not exist.</p>
	<?php endif; ?>
</div>

<?php require_once('partials/footer.php'); ?>