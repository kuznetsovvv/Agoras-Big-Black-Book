(function() {
	tinymce.PluginManager.add( 'custom_link_class', function( editor, url ) {
		// Add Button to Visual Editor Toolbar
		editor.addButton('custom_link_class', {
			title: 'Insert Button Link',
			cmd: 'custom_link_class',
		});	
	});
})();