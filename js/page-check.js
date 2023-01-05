$(function () {
	const currentTab = "nav .current";

	// Check if the current page has been refreshed or if it has been changed (by checking its childrens).
	// If it's just a refresh, no animation will play
	if ($(window).outerWidth() > 990 && isNewPage(currentTab)) {
		setCurrentTabToMemory(currentTab);
		setCurrentPageToMemory(currentTab);

		// Add `.current` animation and title-rotate (only for PC users)
        $(currentTab).css("animation", "fadeCurrentActiveTab .35s ease-in-out forwards");
        $("#mainBodyHeader").addClass("rotate");
	}
});

function setCurrentTabToMemory(currentTab) {
	localStorage.lastTab = $($(currentTab)[0]).html();
}


function setCurrentPageToMemory() {
	localStorage.lastPage = getPageUri();
}

function isNewPage(currentTab) {
	const isLastTab = localStorage.lastTab && localStorage.lastTab == $($(currentTab)[0]).html();

	const isLastPage = localStorage.lastPage && localStorage.lastPage == getPageUri();

	return !isLastTab && !isLastPage;
}

function getPageUri() {
	// Get URI ("blabla.com/utente/login")
	let currentPageUri = window.location.href;
	
	// Get last slash position ("utente/")
	let uriPos = currentPageUri.lastIndexOf('/');

	// Return substring from original (starting from last slash position + 1 to ignore the slash)
	return currentPageUri.substr(uriPos + 1);
}