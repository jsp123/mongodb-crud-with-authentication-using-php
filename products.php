<?php require_once('inc/config.php'); ?>
<?php require_once('partials/header.php'); ?>
  
<div class="container products-view-all">
	<form class = "post-list">
		<input type = "hidden" value = "" />
	</form>
	
	<div class="clearfix">
		<article class="navbar-form navbar-left p-0 m-0 ml-b">
			<div class="form-group">
				<label>Per Page: </label>
				<select class="form-control post_max m-b">
					<option value="20">20</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
				<label>Search Keyword: </label>
				<input type="text" class="form-control post_search_text m-b" placeholder="Enter a keyword" />
			</div>
			<div class="form-group">
				<label>Order By: </label>
				<select class="form-control post_name m-b">
					<option value="name">Title</option>
					<option value="price">Price</option>
					<option value="quantity">Quantity</option>
				</select>
				<select class="form-control post_sort m-b">
					<option value="ASC">ASC</option>
					<option value="DESC">DESC</option>
				</select>
			</div>
			<input type = "submit" value = "Filter" class = "btn btn-primary post_search_submit m-b" />
		</article>
	</div>
	
	<hr />
	
	<div class="clearfix">
		<div class="pagination-container clearfix"></div>
		<div class="pagination-nav"></div>
	</div>
</div>

<?php require_once('partials/footer.php'); ?>