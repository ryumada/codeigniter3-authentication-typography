// Dynamic Router
document.body.addEventListener('click', event => {
	if (!event.target.className.match('dynamic-router')) {
		return true;
	}
	event.preventDefault();

	const element = event.target;
	const xhttp = new XMLHttpRequest();
	xhttp.onloadend = function () {
		const response = JSON.parse(xhttp.response);
		// add current html state and ist page title to window.history
		if (window.history.state === null) {
			window.history.replaceState({
				"html": document.querySelector('main').innerHTML,
				"pageTitle": document.title
			},
				"",
				document.URL
			)
		}
		// replace the current main content to the response one
		document.querySelector('main').innerHTML = response.html;
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
	xhttp.open('GET', element.getAttribute('href'), true);
	xhttp.setRequestHeader('Http-X-Is-Ajax', 'true');
	xhttp.send();
});

// Handle back/forth browser navigation with the saved state
window.onpopstate = (e) => {
	if (e.state) {
		document.querySelector('main').innerHTML = e.state.html;
		document.title = e.state.pageTitle;
	}
}
