let pswInterval;
let pswTimer = 3;
let currentPswTimer;

let scrollContainer, scrollPosition, mouseDownHandler, mouseMoveHandler, mouseUpHandler;

$(function () {
	$(".hidden").mouseenter(function () {
		pswTimer = 3;
		currentPswTimer = $($(this).find('.timer'));
		currentPswTimer.text(pswTimer);

		pswInterval = setInterval(function () {
			if (--pswTimer <= 0) {
				clearPswTimer();
				return;
			}

			currentPswTimer.text(pswTimer);
		}, 333);
	});

	$('.hidden').mouseleave(function () {
		clearPswTimer();
	});

	scrollContainer = $('.scrollContainer')[0];

	scrollPosition = {
		top: 0,
		left: 0,
		x: 0,
		y: 0
	};

	mouseDownHandler = function (e) {
		// If the user is trying to select a text
		if ($("span:hover, p:hover, a:hover").length > 0) return;

		switch (e.which) {
			// Left click
			case 1:
				// Change the cursor and prevent user from selecting the text
				scrollContainer.style.cursor = 'grabbing';

				$(scrollContainer).find("table").addClass("dragging");
				document.getSelection().removeAllRanges();

				scrollPosition = {
					// The current scroll 
					left: scrollContainer.scrollLeft,
					top: scrollContainer.scrollTop,
					// Get the current mouse position
					x: e.clientX,
					y: e.clientY,
				};

				$(scrollContainer).mousemove(mouseMoveHandler).mouseup(mouseUpHandler);
				return;

			default:
				return;
		}
	};

	mouseMoveHandler = function (e) {
		scrollContainer.style.userSelect = 'none';
		document.getSelection().removeAllRanges();

		// How far the mouse has been moved
		const dx = e.clientX - scrollPosition.x;
		const dy = e.clientY - scrollPosition.y;

		// Scroll the element
		scrollContainer.scrollTop = scrollPosition.top - dy;
		scrollContainer.scrollLeft = scrollPosition.left - dx;
	};

	mouseUpHandler = function () {
		scrollContainer.style.cursor = 'grab';
		scrollContainer.style.removeProperty('user-select');

		$(scrollContainer).find("table").removeClass("dragging");
		document.getSelection().removeAllRanges();

		$(scrollContainer).unbind("mousemove").unbind("mouseup");
	};

	$(scrollContainer).mousedown(mouseDownHandler);
});

function clearPswTimer() {
	$(currentPswTimer)?.empty();
	currentPswTimer = null;
	pswTimer = 3;
	clearInterval(pswInterval);
}