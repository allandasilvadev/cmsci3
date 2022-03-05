/* Tinymce */
tinymce.init({
	selector: 'textarea',
	content_style: 'body { font-family: serif; font-size: 18px; }',
	branding: false,
	menubar: false,
	statusbar: false,
	toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | forecolor | image',
	plugins: 'image,textcolor',
	height: 460,
	editor_encoding: 'raw',
	relative_urls: false,
	remove_script_host: false,
	extended_valid_elements: 'img[style|class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]'
});

function pegar_imagens( uri, description ) {
	tinyMCE.execCommand( "mceInsertContent", false, '<img src="' + uri + '" style="display:inline-block; max-height: 250px; max-width: 250px; width: auto; height: auto;" title="' + description + '" />' );
}