$(function () {
	$(window).scroll(function() {
		let scroller = $("#scrollToTop");

		if ($(window).scrollTop() > 50) {
			scroller.removeClass("invisible");
		}
		else {
			scroller.addClass("invisible");
		}
	});

	$("#scrollToTop").on("click", function () {
		if ($(window).scrollTop() > 0) {
			window.scrollTo(0, 0);
		}
	});
});