// DEPENDENT to public/assets/router/main-router.js

// add ckeditorScripts to Document
this.initCkeditorScripts = () => {
	const editorElements = document.querySelectorAll('.editor');
	console.log(editorElements);
}

/**
 * Call this function after document load complete.
 * If using XMLHttpRequest, you should call this function after getting the response.
 */

	// ClassicEditor
	// 	.create( document.querySelectorAll('.ckeditor') )
	// 	.catch( error => {
	// 		console.log(error);
	// 	} );

