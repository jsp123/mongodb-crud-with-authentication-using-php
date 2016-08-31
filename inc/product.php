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
		$update_item = $products->update(
			array( '_id' => new MongoId( $id ) ),
			array( '$set' => $data )
		);
		
		/* Check if the insert was successfull */
		return $products->findOne() ? true : false;
		
	} else {
		echo false;
	}
	
}