// DEPENDENT to public/assets/router/main-router.js

/**
 * Inject this init script to window element.
 */
this.initCkeditorScripts = () => {
	const editorElements = document.querySelectorAll('.editor');
	console.log(editorElements);
}

	// ClassicEditor
	// 	.create( document.querySelectorAll('.ckeditor') )
	// 	.catch( error => {
	// 		console.log(error);
	// 	} );

