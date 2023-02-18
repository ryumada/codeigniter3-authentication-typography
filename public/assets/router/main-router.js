const ANCHORMAINROUTERCLASS = 'main-router';
const MAINCONTENTID = 'mainContent';
const MAINCONTENTSCRIPTCLASS = 'mainContentScript';

// Main Router for going through pages.
document.body.addEventListener('click', event => {
	if (!event.target.className.match(`${ANCHORMAINROUTERCLASS}`)) {
		return true;
	}
	event.preventDefault();

	const element = event.target;

	try {
		const xhttp = new XMLHttpRequest();
		xhttp.addEventListener('error', (e) => {
			showToast({ title: 'Main Router Error?!', msg: 'Error while routing to the main content' });
		});
		xhttp.addEventListener('load', bringNewPartOfPage);
		xhttp.open('GET', element.getAttribute('href'), true);
		xhttp.setRequestHeader('Http-X-Is-Ajax', 'true');
		xhttp.send();
	} catch (error) {
		showToast({ msg: 'xhttp error' });
	}
});

/**
 * Handle back/forth browser navigation with the saved state
 * 
 * @param {*} e event variable from `window` element
 */
window.onpopstate = (e) => {
	if (e.state) {
		const mainContent = document.querySelector(`#${MAINCONTENTID}`);

		try {
			mainContent.innerHTML = e.state.html;
			injectMainScriptContents(e.state.scripts);
			document.title = e.state.titlepage;
		} catch (error) {
			showToast({ msg: `Back/Forth function error?!` })
		}
	}
}

/**
 * If xhttp request success, run this command
 * 
 * @param {*} event taken from `xhttp.addEventListener('load', bringNewPartOfPage);`
 */
const bringNewPartOfPage = (event) => {
	const response = JSON.parse(event.target.response);
	const mainContent = document.querySelector(`#${MAINCONTENTID}`);
	const scriptElements = document.querySelectorAll(`script.${MAINCONTENTSCRIPTCLASS}`);

	if (window.history.state === null) {
		addCurrentDocumentStateToWindowHistory(mainContent);
	}

	deleteInjectedMainScriptContents(scriptElements);
	injectMainScriptContents(response.scripts);

	mainContent.innerHTML = (response.html) ? response.html : "";

	// add history new state to the browser history
	addNewDocumentStateToWindowHistory(response);

	document.title = response.titlepage;
}

/**
 * Add current document state into `window.history`.
 * 
 * @param {document.querySelector(`#${MAINCONTENTID}`)} mainContent The main content from MAINCONTENTID.
 */
const addCurrentDocumentStateToWindowHistory = (mainContent) => {
	try {
		window.history.replaceState({
			"html": ((mainContent.innerHTML) ? mainContent.innerHTML : ""),
			"scripts": createScriptsSrcArrayFromScriptElements(scriptElements),
			"titlepage": document.title
		},
			"",
			document.URL
		)
	} catch (error) {
		showToast({ msg: 'addCurrentDocumentStateToWindowHistory error.'});
		console.log(error);
	}
}

/**
 * 
 * @param {XMLHttpRequest.response} response A response object from xhttp request.
 */
const addNewDocumentStateToWindowHistory = (response) => {
	try {
		window.history.pushState({
			"html": (response.html) ? response.html : "",
			"scripts": response.scripts,
			"titlepage": response.titlepage,
		},
			"",
			response.urlpath
		);
	} catch (error) {
		showToast({ msg: "addNewDocumentStateToWindowHistory error." });
		console.log(error);
	}
}

/**
 * Delete injected main content scripts
 * 
 * @param {Iterable}	scriptElements	Taken from `document.querySeletorAll(`script.${MAINCONTENTSCRIPT}`);`
 */
const deleteInjectedMainScriptContents = (scriptElements) => {
	try {
		scriptElements.forEach((scriptElement) => {
			scriptElement.remove();
		});
	} catch (error) {
		showToast({ msg: 'deleteInjectedMainScriptContents error.' });
	}
}

/**
 * Create an Array of src scripts from script elements.
 * 
 * @param {Iterable} scriptElements Taken from `document.querySeletorAll(`script.${MAINCONTENTSCRIPT}`);`
 * @returns {Array} An array of src scripts.
 */
const createScriptsSrcArrayFromScriptElements = (scriptElements) => {
	try {
		const srcScripts = new Array();
		scriptElements.forEach((scriptElement) => {
			srcScripts.push(scriptElement.getAttribute('src'));
		});
		return srcScripts;
	} catch (error) {
		showToast({ msg: 'createScriptsSrcArrayFromScriptElements error.' });
	}
}

/**
 * Inject main content scripts
 * 
 * @param {Array} responseScripts	An array that contains scripts location.
 */
const injectMainScriptContents = (responseScripts) => {
	try {
		for (const script of responseScripts) {
			const scriptElement = document.createElement('script');
			scriptElement.setAttribute('class', MAINCONTENTSCRIPTCLASS)
			scriptElement.setAttribute('type', 'text/javascript');
			scriptElement.setAttribute('src', script);

			document.body.appendChild(scriptElement);
		}
	} catch (error) {
		showToast({ msg: 'injectMainScriptContents error.' });
	}
}
