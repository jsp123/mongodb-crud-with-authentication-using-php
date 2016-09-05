<?php 
require_once('../../config.php');

$pag_content = '';
$pag_navigation = '';

if( isset( $_POST['action'] ) && $_POST['action'] == 'get-all-products' ){
	
	$page = $_POST['data']['page']; /* The page we are currently at */
	$name = $_POST['data']['name']; /* The name of the column name we want to sort */
	$sort = $_POST['data']['sort']; /* The order of our sort (DESC or ASC) */
	$max  = $_POST['data']['max']; /* Number of items to display per page */
	$cur_page = $page;
	$page -= 1;
	$per_page = $max ? $max : 40; 
	$previous_btn = true;
	$next_btn = true;
	$first_btn = true;
	$last_btn = true;
	$start = $page * $per_page;
	
	$where_search = array();
	
	/* Check if there is a string inputted on the search box */
	if( ! empty( $_POST['data']['search']) ){
		/* If a string is inputted, include an additional query logic to our main query to filter the results */
		$filter = new MongoRegex('/' . $_POST['data']['search'] . '/i');
		$where_search = array(
			'$or' => array(
				array('name' => $filter),
				array('price' => $filter),
			)
		);
	}
		
	/* Retrieve all the posts */
	$all_items = $products
		->find( $where_search )
		->limit( $per_page )
		->skip( $start )
		->sort( array(
			$name => $sort == 'ASC' ? 1 : -1
		));
	
	$count = $products
		->find( $where_search )
		->count();
		
	/* Check if our query returns anything. */
	if( $count ){
		
		/* Iterate thru each item */
		$i = 1;
		foreach( $all_items as $key => $item ){
			
			$item = (object) $item;
			$status = $item->status == 1 ? 'Active' : 'Inactive';
			
			if ( $i % 4 == 1 ){
				$pag_content .= '<div class="clearfix">';
			}
			
			$pag_content .= '
			<div class="col-sm-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						' . $item->name . '
					</div>
					<div class="panel-body p-0 p-b">
						<a href="products-single.php?item=' . $item->_id . '"><img src="img/uploads/' . $item->featured_image . '" width="100%" class="img-responsive" /></a>
						<div class="list-group m-0">
							<div class="list-group-item b-0 b-t">
								<i class="fa fa-calendar-o fa-2x pull-left ml-r"></i>
								<p class="list-group-item-text">Price</p>
								<h4 class="list-group-item-heading">$' . number_format( $item->price, 2 ) . '</h4>
							</div>
							<div class="list-group-item b-0 b-t">
								<i class="fa fa-calendar fa-2x pull-left ml-r"></i>
								<p class="list-group-item-text">Quantity</p>
								<h4 class="list-group-item-heading">' . $item->quantity . '</h4>
							</div>
						</div>
					</div>
					 <div class="panel-footer">
						</p><a href="products-single.php?item=' . $item->_id . '" class="btn btn-success btn-block">View Item</a></p>
					 </div>
				</div>
			</div>
			';
			
			if ( $i % 4 == 0 ){
				$pag_content .= '</div>';
			}
			
			$i++;
		}
		
		if ( $i % 4 != 1 ){
			$pag_content .= '</div>';
		}
		
	/* If the query returns nothing, we throw an error message */
	} else {
		$pag_content .= '<p class = "bg-danger p-d">No results found.</p>';
		
	}

	$pag_content = $pag_content . "<br class = 'clear' />";
	
	$no_of_paginations = ceil($count / $per_page);

	if ($cur_page >= 7) {
		$start_loop = $cur_page - 3;
		if ($no_of_paginations > $cur_page + 3)
			$end_loop = $cur_page + 3;
		else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
			$start_loop = $no_of_paginations - 6;
			$end_loop = $no_of_paginations;
		} else {
			$end_loop = $no_of_paginations;
		}
	} else {
		$start_loop = 1;
		if ($no_of_paginations > 7)
			$end_loop = 7;
		else
			$end_loop = $no_of_paginations;
	}
	  
	$pag_navigation .= "<ul>";

	if ($first_btn && $cur_page > 1) {
		$pag_navigation .= "<li p='1' class='active'>First</li>";
	} else if ($first_btn) {
		$pag_navigation .= "<li p='1' class='inactive'>First</li>";
	} 

	if ($previous_btn && $cur_page > 1) {
		$pre = $cur_page - 1;
		$pag_navigation .= "<li p='$pre' class='active'>Previous</li>";
	} else if ($previous_btn) {
		$pag_navigation .= "<li class='inactive'>Previous</li>";
	}
	for ($i = $start_loop; $i <= $end_loop; $i++) {

		if ($cur_page == $i)
			$pag_navigation .= "<li p='$i' class = 'selected' >{$i}</li>";
		else
			$pag_navigation .= "<li p='$i' class='active'>{$i}</li>";
	}
	
	if ($next_btn && $cur_page < $no_of_paginations) {
		$nex = $cur_page + 1;
		$pag_navigation .= "<li p='$nex' class='active'>Next</li>";
	} else if ($next_btn) {
		$pag_navigation .= "<li class='inactive'>Next</li>";
	}

	if ($last_btn && $cur_page < $no_of_paginations) {
		$pag_navigation .= "<li p='$no_of_paginations' class='active'>Last</li>";
	} else if ($last_btn) {
		$pag_navigation .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
	}

	$pag_navigation = $pag_navigation . "</ul>";	
}


$response = array(
	'content' 		=>	$pag_content,
	'navigation' 	=>	$pag_navigation,
);

echo json_encode( compress_output_light( $response ) );

exit();