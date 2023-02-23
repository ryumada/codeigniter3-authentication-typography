// DEPENDENT to public/assets/router/main-router.js

/**
 * Inject this init script to window element.
 */
this.initCkeditorScripts = () => {
	const editorElements = document.querySelectorAll('.ckeditor');
	console.log(editorElements);
}

	// ClassicEditor
	// 	.create( document.querySelectorAll('.ckeditor') )
	// 	.catch( error => {
	// 		console.log(error);
	// 	} );

	// TODO: Initialize ckeditor till it can show
	// TODO: Add CKFinder and connect it to backend
