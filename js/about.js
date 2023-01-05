let scrollCondition;

$(function () {
	$(window).on("scroll load resize", function () {
		let scrollTop = $(this).scrollTop();

		if ($(this).outerWidth() > 990)
			scrollImage(".school-image", scrollTop);
		checkImageOnScroll(".profile-image-container", scrollTop);
	});
});

function checkImageOnScroll(image, scrollTop) {
	// inspired from: https://stackoverflow.com/a/21561584
	let hT = $(image).offset().top,
		hH = $(image).outerHeight(),
		wH = $(window).height(),
		wS = scrollTop;

	scrollCondition = (hT + (hH) - wH + 50);

	if (wS > scrollCondition) {
		$(image).addClass("active");
	} else {
		$(image).removeClass("active");
	}
}

function scrollImage(image, scrollTop) {
	// inspired from: https://gist.github.com/omgmog/7198844

	let value = (-.4 * scrollTop / 2.5 - 50);

	$(image).css({
		'background-position': 'center ' + value + 'px'
	});
}