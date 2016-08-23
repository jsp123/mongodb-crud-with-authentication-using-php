/**
 * Helper function to get append the loading image to message container when submitting via AJAX
 * 
 * @param textarea, height
 */
function load_ckeditor( textarea, height ) {			
	CKEDITOR.config.allowedContent = true;
	CKEDITOR.replace( textarea, {
		toolbar: null,
		toolbarGroups: null,	
		height: height
	});
}
		
/**
 * Helper function to command CKEditor to update the instancnes before performing the AJAX call.
 * This will populate the hidden textfields with the proper values coming from the CKEditor 
 *
 */
function update_ckeditor_instances() {
	for ( instance in CKEDITOR.instances ) {
		CKEDITOR.instances[instance].updateElement();
	}
}