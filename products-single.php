<?php require_once('inc/config.php'); ?>
<?php require_once('partials/header.php'); ?>
<?php
if( isset( $_GET['item'] ) && ! empty( $_GET['item'] ) ):
	$item_id = $_GET['item'];
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
		
		$item_images = array();
		foreach( $item->images as $image ){
			$item_images[] = array(
				'small'	=>	UPLOADS_URL . $image,
				'big'	=>	UPLOADS_URL . $image
			);
		}
		?>
		<div class="container products-view">
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading">
						<?php echo $item->name; ?>
					</div>
					<div class="panel-body">
						<input type = "hidden" class = "item-images-json" value = '<?php echo (string) json_encode( $item_images, JSON_UNESCAPED_SLASHES ) ?>' />
						<div class = "imageviewer">
							<div class = "image-container"></div>
							<span class = "glyphicon glyphicon-chevron-left prev"></span>
							<span class = "glyphicon glyphicon-chevron-right next"></span>
							
							<div class = "footer-info">
								<span class = "current"></span>/<span class="total"></span>
							</div>
						</div>
					
						<hr />
						<h3>Product Description</h3>
						<?php echo $item->content; ?>
					</div>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						Product Details
					</div>
					<div class="panel-body">
						<h2 class="text-danger m-0 ml-b f-b">$<?php echo number_format( $item->price, 2 ); ?> <small>only</small></h2>
						
						<div class="clearfix">
							<div class="col-md-6">
								<span class="sr-only">Four out of Five Stars</span>
								<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
								<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
								<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
								<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
								<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
								<span class="label label-success">7</span>
							</div>
							<div class="col-md-6">
								<a href="#_" class="monospaced"><span class="glyphicon glyphicon-pencil"></span> Write a Review</a>
							</div>
						</div>
						
						<hr />
						
						<p><strong>Date Posted</strong>: <?php echo date( "F j, Y, g:i a", strtotime( $item->date ) ); ?></p>
						<p><strong>On Stock</strong>: <?php echo $item->quantity; ?></p>
						
						<hr />
						
						<a href="#_" class="btn btn-success btn-block"><span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart</a>
						<a href="#_" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-star"></span> Add to Wishlist</a>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-heading">
						Reviews
					</div>
					<div class="panel-body">
					</div>
				</div>
			</div>
		</div>
	<?php else: ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				Not Found!
			</div>
			<div class="panel-body">
				<p class="bg-danger p-d">The product you are looking is not found</p>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>


<?php require_once('partials/footer.php'); ?>