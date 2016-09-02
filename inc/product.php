<?php 
function delete_product( $id ){
	
	global $products;
	
	/* Check if object ID is valid */
	if( MongoId::isValid( $id ) == true ){
		
		$product = get_product( $id );
		
		/* Delete all images of this product */
		if( isset( $product->images ) && ! empty( $product->images ) ){
			foreach( $product->images as $image ){
				$image_path = ABSPATH . '/img/uploads/' . $image;
				if( file_exists( $image_path ) == true ){
					unlink( $image_path );
				}
			}
		}
		
		$remove = $products->remove( 
			array( '_id' => new MongoID( $id ) )
		);
		
		return $remove ? true : false;
		
	} else {
		return false;
		
	}
}

function update_product( $id, $data ){
	
	global $products;
	
	/* Check if object ID is valid */
	if( MongoId::isValid( $id ) == true ){
		
		/* Update our fields from the database */
		$products->update(
			array( 
				'_id' 		=> new MongoId( $id ), 
				'author' 	=> current_user()->email
			),
			array( '$set' => $data )
		);
		
		/* Check if the update was successfull */
		return $products->findOne() ? true : false;
		
	} else {
		echo false;
	}
	
}

function add_product( $data ){
	
	global $products;
	
	/* Set the author of the product */
	$data['author'] = current_user()->email;
	
	/* Create the product */
	$products->insert( $data, array('fsync' => true) );
	
	/* After the insert, we can already access the _id of the new item */
	$item_id = $data['_id'];
	return $item_id ? $item_id : false;
	
}

function get_product( $item_id ){
	
	global $products;
	
	$item = $products->findOne( 
		array('_id' => new MongoId( $item_id ) ) 
	);
	
	/* For better readability, I usually convert the array to an object */
	$item = (object) $item;
	
	return $item;
}

function unset_image( $item_id, $image ){
	
	global $products;
	
	$remove = $products->update( 
		array('_id' => new MongoID( $item_id ) ),
		array('$pull' => 
			array(
				'images' => $image
			)
		)
	);
	
	return $remove ? true : false;
	
}

function set_featured_image( $item_id, $image ){
	
	global $products;
	
	$set_featured_image = $products->update( 
		array('_id' => new MongoID( $item_id ) ),
		array('$set' => 
			array(
				'featured_image' => $image
			)
		)
	);
	
	return $set_featured_image ? true : false;
	
}

function add_image( $item_id, $image ){
	
	global $products;
	
	$add_image = $products->update( 
		array('_id' => new MongoID( $item_id ) ),
		/** 
		 * Use "$addToSet" instead of "$push" to tell mongoDB to 
		 * add the image only if it does not exist yet in the set.
		 */
		array('$addToSet' => 
			array(
				'images' => $image
			)
		)
	);
	
	return $add_image ? true : false;
	
}