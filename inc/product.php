<?php 
function delete_product( $id ){
	
	global $products;
	
	/* Check if object ID is valid */
	if( MongoId::isValid( $id ) == true ){
		
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
	$products->insert( $data );
	
	/* Check if the insert was successfull */
	return $products->findOne() ? true : false;
	
}