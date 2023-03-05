/**
 * DEPENDENT:
 * - public/assets/router/main-router.js
 * - showToast from application/views/5_body_scripts.php
 */

const CKEDITORWATCHDOGNAME = 'ckeditorWatchdog';
const AUTOSAVEURL = 'http://localhost:81/ckeditor/autosave';
const UPLOADURL = 'http://localhost:81/ckeditor/uploadimage';

/**
 * Inject this init script to window element.
 */
this.initCkeditorScripts = () => {
	if (typeof CKSource === 'undefined') {
		document.querySelector(`script[src="${window[`${MAINCONTENTSCRIPTLIST}`][0]}"]`).addEventListener('load', asyncCreateCKEDITOR);
	} else {
		window.ckeditorInstances.forEach(instance => {
			instance.destroy();
			console.log('ckeditor destroyed');
		});
		asyncCreateCKEDITOR();
	}
}

/**
 * An async function to call CreateCKEDITOR function
 */
async function asyncCreateCKEDITOR() {
	await createCKEDITOR();
}

/**
 * A function to create CKEDITOR Instance
 * !!! Must be called inside async function !!!
 * 
 * @returns Promise for creating CKEDITOR instance
 */
function createCKEDITOR() {
	return new Promise(resolve => {
		const editorElements = document.querySelectorAll('.ckeditor');
		window.ckeditorInstances = new Array();

		editorElements.forEach(editorElement => {
			CKSource.Editor.create(editorElement, {
				simpleUpload: {
					// The URL that the images are uploaded to.
					uploadUrl: UPLOADURL,

					// Enable the XMLHttpRequest.withCredentials property.
					withCredentials: false,

					// Headers sent along with the XMLHttpRequest to the upload server.
					headers: {
						'Http-Is-Ajax': 'true'
						// 'X-CSRF-TOKEN': 'CSRF-Token',
						// Authorization: 'Bearer <JSON Web Token>'
					}
				},
				autosave: {
					waitingTime: 5000, // in ms
					save(editor) {
						// The saveData() function must return a promise
						// which should be resolved when the data is successfully saved.
						return saveData(editor.getData());
					}
				}
			})
				.then(editor => {
					window.ckeditorInstances.push(editor);
					console.log(editor);
				})
				.catch(error => {
					console.error(error);
				});
		});

		resolve();
	});
}

/**
 * A function to call autosave function
 * 
 * @param {String} an HTML String from CKEDITORInstance.getData() 
 * @returns a Promise for CKEDITOR Instance.
 */
function saveData(data) {
	return new Promise(resolve => {
		const formData = new FormData();
		const xhttp = new XMLHttpRequest();

		formData.append('ckeditorData', data);
		
		xhttp.addEventListener('error', () => {
			resolve(false);
		});
		xhttp.addEventListener('load', (event) => {
			resolve(event.target.response);
		});
		xhttp.open('POST', AUTOSAVEURL, true);
		xhttp.setRequestHeader('Http-Is-Ajax', 'true');
		xhttp.send(formData);
		// setTimeout(() => {
		// 	console.log('Saved', data);

		// 	resolve();
		// }, console.log('error'));
	});
}

/**
 * A function to handle any Error while creating CKEDITOR Instance.
 * 
 * @param {CKEDITORINSTANCE.error} error An error object taken from CKEDITOR Instance. 
 */
function handleError(error) {
	console.error('Oops, something went wrong!');
	console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
	console.warn('Build id: nia0y3n6k3hi-owlz6ccjh4oy');
	console.error(error);
}
