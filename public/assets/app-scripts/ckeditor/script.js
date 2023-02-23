/**
 * DEPENDENT:
 * - public/assets/router/main-router.js
 * - showToast from application/views/5_body_scripts.php
 */

/**
 * Inject this init script to window element.
 */
this.initCkeditorScripts = () => {
	if (document.querySelector(`script[src="${window[`${MAINCONTENTSCRIPTLIST}`][0]}"]`) === null) {
		document.querySelector('.ckeditor').addEventListener('load', loadCKEDITOR);
	} else {
		loadCKEDITOR();
	}
}

/**
 * A function to load CKEDITOR.
 */
function loadCKEDITOR() {
	const editorElements = document.querySelectorAll('.ckeditor');
	editorElements.forEach((editorElement => {
		BalloonEditor
			.create(editorElement)
			.catch(error => {
				showToast({ msg: 'CKEditor could not loaded.' })
			});
	}));
}

	// ClassicEditor
	// 	.create( document.querySelectorAll('.ckeditor') )
	// 	.catch( error => {
	// 		console.log(error);
	// 	} );

	// TODO: Initialize ckeditor till it can show
	// TODO: Add CKFinder and connect it to backend
