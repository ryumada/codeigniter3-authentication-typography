/**
 * DEPENDENT:
 * - public/assets/router/main-router.js
 * - showToast from application/views/5_body_scripts.php
 */

/**
 * Inject this init script to window element.
 */
this.initCkeditorScripts = () => {
	if (typeof CKSource === 'undefined') {
		document.querySelector(`script[src="${window[`${MAINCONTENTSCRIPTLIST}`][0]}"]`).addEventListener('load', loadCKEDITOR);
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
		const watchdog = new CKSource.EditorWatchdog();

		window.watchdog = watchdog;

		watchdog.setCreator((element, config) => {
			return CKSource.Editor
				.create(element, config)
				.then(editor => {
					return editor;
				})
		});

		watchdog.setDestructor(editor => {
			return editor.destroy();
		});

		watchdog.on('error', handleError);

		watchdog
			.create(editorElement, {
				licenseKey: '',
			})
			.catch(handleError);
	}));
}

function handleError(error) {
	console.error('Oops, something went wrong!');
	console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
	console.warn('Build id: 5vee566k1w7v-53kpoe29jnml');
	console.error(error);
}

	// ClassicEditor
	// 	.create( document.querySelectorAll('.ckeditor') )
	// 	.catch( error => {
	// 		console.log(error);
	// 	} );

	// TODO: Initialize ckeditor till it can show
	// TODO: Add CKFinder and connect it to backend
