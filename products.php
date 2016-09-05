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
				<select class="form-control post_max">
					<option value="40">40</option>
					<option value="80">80</option>
					<option value="160">160</option>
				</select>
				<label>Search Keyword: </label>
				<input type="text" class="form-control post_search_text" placeholder="Enter a keyword">
			</div>
			<input type = "submit" value = "Filter" class = "btn btn-primary post_search_submit" />
		</article>
	</div>
	
	<hr />
	
	<div class="clearfix">
		<div class="pagination-container clearfix"></div>
		<div class="pagination-nav"></div>
	</div>
</div>

<?php require_once('partials/footer.php'); ?>