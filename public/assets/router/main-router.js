// Main Router for going through pages.
document.body.addEventListener('click', event => {
	if (!event.target.className.match('main-router')) {
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
		showToast({ msg: 'xhttp error' })
	}
});

/**
 * Handle back/forth browser navigation with the saved state
 * 
 * @param {*} e event variable from `window` element
 */
window.onpopstate = (e) => {
	if (e.state) {
		const mainContent = document.getElementById('mainContent');
		try {
			mainContent.innerHTML = e.state.html
			document.title = e.state.pageTitle;
		} catch (error) {
			showToast({ msg: 'There are no mainContent on the page.' })
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
	// add current html state and ist page title to window.history
	if (window.history.state === null) {
		window.history.replaceState({
			"html": ((document.getElementById('mainContent')) ? document.getElementById('mainContent').innerHTML : ""),
			"pageTitle": document.title
		},
			"",
			document.URL
		)
	}
	// replace the current main content to the response one
	document.getElementById('mainContent').innerHTML = response.html;
	// add history current state to the browser history
	window.history.pushState({
		"html": response.html,
		"pageTitle": response.titlepage,
	},
		"",
		response.urlpath
	);
	document.title = response.titlepage;
}

