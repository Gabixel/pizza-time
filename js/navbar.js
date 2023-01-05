$(function () {
	// Toggle when clicking the button for the language dropdown
	$("nav .link.language").click(toggleLanguageDropdown);

	$(window).resize(function () {
		const dropdown = "nav .lang-dropdown";

		if ($(dropdown).hasClass("visible"))
			toggleLanguageDropdown();

		if ($(window).outerWidth() <= 990) {
			if ($("nav .link:not(.topnav-logo)").attr("tabindex") != -1)
				$("nav .link:not(.topnav-logo)").attr("tabindex", -1);
		} else {
			if ($("nav .link:not(.topnav-logo)").attr("tabindex") != 0)
				$("nav .link:not(.topnav-logo)").attr("tabindex", 0);
		}
	});

	// If the clicked element is outside the language area, and the dropdown is visible, the dropdown will be closed
	$(document).click(function (e) {
		const dropdown = "nav .lang-dropdown";

		if (!$(e.target).parents().addBack().is(dropdown) &&
			!$(e.target).parents().addBack().is(".link.language") &&
			$(dropdown).hasClass("visible")) {

			toggleLanguageDropdown();
		}
	});

	$("nav .hamburger-bar").click(function () {
		$(this).toggleClass("active");
		$("nav").toggleClass("visible");
	});
});

// Toggle dropdown function
function toggleLanguageDropdown() {
	const dropdown = "nav .lang-dropdown";

	// Toggle "active" class to the dropdown icon
	$("nav .link.language").toggleClass("active");

	// Toggles the dropdown
	$(dropdown).toggleClass("visible");
}