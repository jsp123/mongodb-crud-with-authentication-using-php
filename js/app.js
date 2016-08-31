/**
 * App Class
 *
 * @created		08/19/2016
 */

/**
 * Setup a App namespace to prevent JS conflicts.
 */
var app = {
		
    
	Posts: function() {
		
		/**
		 * This method contains the list of functions that needs to be loaded
		 * when the "Posts" object is instantiated.
		 *
		 */
		this.init = function() {
			// this.loaded_posts_pagination();
			this.get_items_pagination();
			this.add_post();
			this.update_post();
			this.delete_post();
		}
		
		/**
		 * Load items pagination.
		 */
		this.get_items_pagination = function() {
			
			_this = this;
			
			/* Check if our hidden form input is not empty, meaning it's not the first time viewing the page. */
			if($('form.post-list input').val()){
				/* Submit hidden form input value to load previous page number */
				data = JSON.parse($('form.post-list input').val());
				_this.ajax_get_items_pagination(data.page, data.th_name, data.th_sort);
			} else {
				/* Load first page */
				_this.ajax_get_items_pagination(1, 'name', 'ASC');
			}
			
			var th_active = $('.table-post-list th.active');
			var th_name = $(th_active).attr('id');
			var th_sort = $(th_active).hasClass('DESC') ? 'DESC': 'ASC';
						
			/* Search */
			$('body').on('click', '.post_search_submit', function(){
				_this.ajax_get_items_pagination(1, th_name, th_sort);
			});
			/* Search when Enter Key is triggered */
			$(".post_search_text").keyup(function (e) {
				if (e.keyCode == 13) {
					_this.ajax_get_items_pagination(1, th_name, th_sort);
				}
			});
			
			/* Pagination Clicks   */                  
			$('body').on('click', '.pagination-nav li.active', function(){
				var page = $(this).attr('p');
				var current_sort = $(th_active).hasClass('DESC') ? 'DESC': 'ASC';
				_this.ajax_get_items_pagination(page, th_name, current_sort);                
			}); 

			/* Sorting Clicks */
			$('body').on('click', '.table-post-list th', function(e) {
				e.preventDefault();                             
				var th_name = $(this).attr('id');
													
				if(th_name){
					/* Remove all TH tags with an "active" class */
					if($('.table-post-list th').removeClass('active')) {
						/* Set "active" class to the clicked TH tag */
						$(this).addClass('active');
					}
					if(!$(this).hasClass('DESC')){
						_this.ajax_get_items_pagination(1, th_name, 'DESC');
						$(this).addClass('DESC');
					} else {
						_this.ajax_get_items_pagination(1, th_name, 'ASC');
						$(this).removeClass('DESC');
					}
				}
			});
		}
		
		/**
		 * AJAX items pagination.
		 */
		this.ajax_get_items_pagination = function(page, th_name, th_sort){
			
			if($(".pagination-container").length){
				$(".pagination-container").html('<img src="img/loading.gif" class="ml-tb" />');
				
				var post_data = {
					page: page,
					search: $('.post_search_text').val(),
					th_name: th_name,
					th_sort: th_sort,
					max: $('.post_max').val(),
				};
				
				$('form.post-list input').val(JSON.stringify(post_data));
				
				var data = {
					action: "demo_load_my_posts",
					data: JSON.parse($('form.post-list input').val())
				};
				
				$.ajax({
					url: 'inc/ajax/products/view.php',
					type: 'POST',
					data: data,
					success: function (response) {
						response = JSON.parse(response);
						
						if($(".pagination-container").html(response.content)){
							$('.pagination-nav').html(response.navigation);
							$('.table-post-list th').each(function() {
								/* Append the button indicator */
								$(this).find('span.glyphicon').remove();    
								if($(this).hasClass('active')){
									if(JSON.parse($('form.post-list input').val()).th_sort == 'DESC'){
										$(this).append(' <span class="glyphicon glyphicon-chevron-down pull-right"></span>');
									} else {
										$(this).append(' <span class="glyphicon glyphicon-chevron-up pull-right"></span>');
									}
								}
							});
						}
					}
				});
			}
		}
		
		/**
		 * Submit updated data via ajax using jquery form plugin
		 */
		this.update_post = function(){
			$('.update-product').ajaxForm({
				beforeSerialize: function() {
					update_ckeditor_instances();
				},
				success: function(response, textStatus, xhr, form) {
					if(response == 0){
						Lobibox.notify('error', {msg: 'Update failed, please try again', size: 'mini', sound: false});
					} else if(response == 1){
						Lobibox.notify('success', {msg: 'Updated Successfully', size: 'mini', sound: false});
					}
				}
            });
		}
		
		/**
		 * Submit new product data via ajax using jquery form plugin
		 */
		this.add_post = function(){
			$('.create-product').ajaxForm({
				beforeSubmit: function(arr, $form, options) {
					var proceed = true;
					
					$('input.required').each(function(index) {
						if($(this).val() == ''){
							Lobibox.notify('error', {msg: 'Please fill-up the required fields', size: 'mini', sound: false});
							proceed = false;
							return false;
						}
					});
					
					return proceed;
				},
				beforeSerialize: function() {
					update_ckeditor_instances();
				},
				success: function(response, textStatus, xhr, form) {
					if(response == 0){
						Lobibox.notify('error', {msg: 'Failed to create the product, please try again', size: 'mini', sound: false});
					} else if(response == 1){
						Lobibox.notify('success', {msg: 'Product created successfully', size: 'mini', sound: false});
					}
				}
            });
		}
		
		/**
		 * Handles the deletion of a single post
		 */
		this.delete_post = function(){
			$('body').on('click', '.delete-product', function(e) {
				e.preventDefault();
				
				var item = $(this);
				var data = { 
					item_id: item.attr('item_id')
				}
				
				$.ajax({
					url: 'inc/ajax/products/delete.php',
					type: 'POST',
					data: data,
					success: function (response) {
						if(response == 0){
							Lobibox.notify('error', {msg: 'Delete failed, please try again', size: 'mini', sound: false});
						} else if(response == 1){
							item.parents('tr').css('background', '#add9ff').fadeOut('fast');
							Lobibox.notify('success', {msg: 'Deleted Successfully', size: 'mini', sound: false});
						}
					}
				});
			});
			
		}
	},
	
	/**
     * Global
     */
    Global: function () {
		
		/**
		 * This method contains the list of functions that needs to be loaded
		 * when the "Global" object is instantiated.
		 *
		 */
		this.init = function() {
			this.set_ckeditor();
			this.set_datepicker();
		}
		
		/**
		 * Load CKEditor plugin
		 */
		this.set_ckeditor = function() {
			if($('#ck-editor-area').length){
				load_ckeditor('ck-editor-area', 300);
			}
		}
		
		/**
		 * Load CKEditor plugin
		 */
		this.set_datepicker = function() {
			if('.datepicker'){
				$('.datepicker').datetimepicker({
                    format: 'YYYY-MM-DD HH:mm:ss'
                });
			}
		}
	}
}

/**
 * When the document has been loaded...
 *
 */
jQuery(document).ready( function () {
		
	global = new app.Global(); /* Instantiate the Global Class */
	global.init(); /* Load Global class methods */
	
	posts = new app.Posts(); /* Instantiate the Posts Class */
	posts.init(); /* Load Posts class methods */
	
});