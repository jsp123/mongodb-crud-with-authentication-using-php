<?php 
require_once('../config.php');

$collection = $db->posts;

$msg = '';
$pag_container = '';
    
if( isset( $_POST['page'] ) ){
	$page = $_POST['page'];
	$cur_page = $page;
	$page -= 1;
	$per_page = 40;
	$previous_btn = true;
	$next_btn = true;
	$first_btn = true;
	$last_btn = true;
	$start = $page * $per_page;
	
	$all_posts = $collection
		->find( array(), array('title', 'content', 'category', 'test1', 'test2') )
		->limit( $per_page )
		->skip( $start );
	
	$count = $collection
		->find()
		->count();
	
	$i = 1;
	foreach( $all_posts as $post ){
		if( $i % 3 == 1){
			$msg .= '<div class="clearfix">';
		}
		
		$msg .= '
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">' . $post['title'] . '</h3>
				</div>
				<div class="panel-body">
					<span class="pull-right">
						<a href="" class="btn btn-success" data-toggle="modal" data-target="#edit-modal"
							data-item-id="' . $post['_id'] . '"
							data-ticket="' . $post['content'] .'"
							data-category="' . $post['category'] .'"
							data-tags="' . $post['test1'] .'"
							data-excerpt="' . $post['test2'] .'"
						>Edit</a>
						<a href="" class="btn btn-danger">Delete</a>
					</span>
					<ul>
						<li>Category: ' . $post['category'] . '</li>
						<li>' . $post['test1'] . '</li>
						<li>' . $post['test2'] . '</li>
					</ul>
				</div>
			</div>
		</div>';
		
		if( $i % 3 == 0){
			$msg .= '</div>';
		}
		
		$i++;
	}
	
	if( $i % 3 != 1){
			$msg .= '</div>';
		}
	
	$msg = "<div class='cvf-universal-content'>" . $msg . "</div><br class = 'clear' />";
	
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
	
	$pag_container .= "
	<div class='cvf-universal-pagination'>
		<ul>";

	if ($first_btn && $cur_page > 1) {
		$pag_container .= "<li p='1' class='active'>First</li>";
	} else if ($first_btn) {
		$pag_container .= "<li p='1' class='inactive'>First</li>";
	}

	if ($previous_btn && $cur_page > 1) {
		$pre = $cur_page - 1;
		$pag_container .= "<li p='$pre' class='active'>Previous</li>";
	} else if ($previous_btn) {
		$pag_container .= "<li class='inactive'>Previous</li>";
	}
	for ($i = $start_loop; $i <= $end_loop; $i++) {

		if ($cur_page == $i)
			$pag_container .= "<li p='$i' class = 'selected' >{$i}</li>";
		else
			$pag_container .= "<li p='$i' class='active'>{$i}</li>";
	}
	
	if ($next_btn && $cur_page < $no_of_paginations) {
		$nex = $cur_page + 1;
		$pag_container .= "<li p='$nex' class='active'>Next</li>";
	} else if ($next_btn) {
		$pag_container .= "<li class='inactive'>Next</li>";
	}

	if ($last_btn && $cur_page < $no_of_paginations) {
		$pag_container .= "<li p='$no_of_paginations' class='active'>Last</li>";
	} else if ($last_btn) {
		$pag_container .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
	}

	$pag_container = $pag_container . "
		</ul>
	</div>";
	
	echo 
	'<div class = "cvf-pagination-content">' . $msg . '</div>' . 
	'<div class = "cvf-pagination-nav">' . $pag_container . '</div>';
	
}

exit();