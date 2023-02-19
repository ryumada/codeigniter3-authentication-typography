/**
 * Main Router for going through pages.
 */

const ANCHORMAINROUTERCLASS = 'main-router';
const MAINCONTENTID = 'mainContent';
const MAINCONTENTSCRIPTCLASS = 'mainContentScript';

document.body.addEventListener('click', event => {
	if (!event.target.className.match(`${ANCHORMAINROUTERCLASS}`)) {
		return true;
	}
	event.preventDefault();

	const element = event.target;

	try {
		(async () => {
			const xhttpResponse = await new Promise(resolve => {
				const xhttp = new XMLHttpRequest();
				xhttp.addEventListener('error', () => {
					resolve(false);
				});
				xhttp.addEventListener('load', (event) => {
					resolve(event.target.response);
				});
				xhttp.open('GET', element.getAttribute('href'), true);
				xhttp.setRequestHeader('Http-X-Is-Ajax', 'true');
				xhttp.send();
			});
			if(!xhttpResponse) {
				showToast({ title: 'Main Router Error?!', msg: 'Error while routing to the main content' });
				return false;
			}
			bringNewPartOfPage(xhttpResponse);
		})();
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
			if (e.state.init_script_index) {
				window['INITSCRIPTNAME'] = e.state.init_script_index;
				runInitScript();
			} else {
				delete window['INITSCRIPTNAME'];
			}
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
const bringNewPartOfPage = (xhttpResponse) => {
	const response = JSON.parse(xhttpResponse);
	const mainContent = document.querySelector(`#${MAINCONTENTID}`);
	
	window['INITSCRIPTNAME'] = response.init_script_index;

	if (window.history.state === null) {
		addCurrentDocumentStateToWindowHistory(mainContent);
	}

	injectMainScriptContents(response.scripts);

	mainContent.innerHTML = (response.html) ? response.html : "";

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
		window.history.replaceState(
			createHistoryStateObject(mainContent.innerHTML, window['INITSCRIPTNAME'], document.title),
			"",
			document.URL
		)
	} catch (error) {
		showToast({ msg: 'addCurrentDocumentStateToWindowHistory error.'});
	}
}

/**
 * 
 * @param {XMLHttpRequest.response} response A response object from xhttp request.
 */
const addNewDocumentStateToWindowHistory = (response) => {
	try {
		window.history.pushState(
			createHistoryStateObject(response.html, response.init_script_index, response.titlepage),
			"",
			response.urlpath
		);
	} catch (error) {
		showToast({ msg: "addNewDocumentStateToWindowHistory error." });
	}
}

/**
 * A function to create History State Object.
 * 
 * @param {String} html Html string to save the view state.
 * @param {*} init_script_index The init script index for init script.
 * @param {*} titlepage The title of the page.
 * @returns {Object} Generated HistoryStateObject
 */
const createHistoryStateObject = (html, init_script_index, titlepage) => {
	return {
		"html": html,
		"init_script_index": init_script_index,
		"titlepage": titlepage
	}
}

/**
 * A function to create script element and append it to document's body
 * and it will be trigger initscript function.
 * 
 * @param {String}	src					The source URL.
 * @param {*} 			initScript	Is the script element is init script?.
 */
const createScriptElement = (src, initScript = false) => {
	// If the script has been injected
	if (document.querySelector(`script[src="${src}"]`) === null) {
		const scriptElement = document.createElement('script');
		scriptElement.setAttribute('class', MAINCONTENTSCRIPTCLASS)
		scriptElement.setAttribute('type', 'text/javascript');
		scriptElement.setAttribute('src', src);
		
		if (initScript) {
			scriptElement.addEventListener('load', () => {
					runInitScript();
			});
		}

		document.body.appendChild(scriptElement);
	} else {
		if (initScript) {
				runInitScript();
		}
	}
}

/**
 * Inject main content scripts
 * 
 * @param {Array} responseScripts	An array that contains scripts location.
 */
const injectMainScriptContents = (responseScripts) => {
	try {
		if(responseScripts) {
			for (const script of responseScripts) {
				if (typeof script === 'object') {
					createScriptElement(script.src, true)
				} else {
					createScriptElement(script)
				}
			}
		}
	} catch (error) {
		showToast({ msg: 'injectMainScriptContents error.' });
	}
}

/**
 * A function to run init script.
 */
const runInitScript = () => {
	window[`${window['INITSCRIPTNAME']}`]();
}
