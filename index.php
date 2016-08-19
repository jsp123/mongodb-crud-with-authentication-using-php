<?php require_once('inc/config.php'); ?>
<?php require_once('partials/header.php'); ?>
  
<div class="container">
	<div class="row">
		<form class = "post-list">
			<input type = "hidden" value = "" />
		</form>
		
		<article class="navbar-form navbar-left ml-b">
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
		
		<br class = "clear" />
		
		<div class = "wave-box-wrapper">
			<div class = "wave-box"></div>
			<table class = "table table-striped table-post-list no-margin">
				<thead>
					<tr>
						<td align = "middle"><input type = "checkbox"></td>
						<th id = "name" class = "active"><a href = "#">Name</a></th>
						<th id = "price"><a href = "#">Price</a></th>
						<th id = "status"><a href = "#">Status</a></th>
						<th id = "date"><a href = "#">Date</a></th>
						<th id = "quantity"><a href = "#">Quantity</a></th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody class = "pagination-container"></tbody>
			</table>
			
			<div class = "pagination-nav"></div>
		</div>
	</div>
</div>

<!-- 
<div class="modal" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label">
	<div class="modal-dialog" role="document">
		<form method="post" action="inc/ajax/update.php" class="update-item">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="edit-modal-label">Edit</h4>
				</div>
				<div class="modal-body">
					<div class="update-response"></div>
					
					<input type="hidden" name="item_id" value="" />
					<div class="form-group">
						<label>Ticket ID</label>
						<input type="text" class="form-control" name="ticket" value="" />
					</div>
					<div class="form-group">
						<label>Category</label>
						<input type="text" class="form-control" name="category" value="" />
					</div>
					<div class="form-group">
						<label>Tags</label>
						<input type="text" class="form-control" name="tags" value="" />
					</div>
					<div class="form-group">
						<label>Excerpt</label>
						<input type="text" class="form-control" name="excerpt" value="" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" class="btn btn-success" value="Update" />
				</div>
			</div>
		</form>
	</div>
</div>
-->

<?php require_once('partials/footer.php'); ?>

