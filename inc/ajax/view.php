<?php 
require_once('../config.php');

$collection = $db->products;
$pag_content = '';
$pag_navigation = '';

if( isset( $_POST['data']['page'] ) ){
	
	$page = $_POST['data']['page']; /* The page we are currently at */
	$name = $_POST['data']['th_name']; /* The name of the column name we want to sort */
	$sort = $_POST['data']['th_sort']; /* The order of our sort (DESC or ASC) */
	$cur_page = $page;
	$page -= 1;
	$per_page = 40; /* Number of items to display per page */
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
				array('price' => $filter)
			)
		);
	}
	
	/* Retrieve all the posts */
	$all_items = $collection
		->find( $where_search, array('name', 'price', 'status', 'date', 'quantity') )
		->limit( $per_page )
		->skip( $start )
		->sort( array(
			$name => $sort == 'ASC' ? 1 : -1
		));
	
	$count = $collection
		->find($where_search)
		->count();
		
	/* Check if our query returns anything. */
	if( $count ){
		
		/* Iterate thru each item */
		foreach( $all_items as $key => $item ){
			
			$item = (object) $item;
			
			$pag_content .= '
			<tr>
				<td align = "middle"><input type = "checkbox"></td>
				<td>' . $item->name . '</td>
				<td>' . $item->price . '</td>
				<td>' . $item->status . '</td>
				<td>' . $item->date . '</td>
				<td>' . $item->quantity . '</td>
			</tr>';         
		}
		
	/* If the query returns nothing, we throw an error message */
	} else {
		$pag_content .= '<td colspan = "7" class = "bg-danger p-d">No results found.</td>';
		
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