let prevSize = 0;

$(function () {

	// Trigger for every next resizing to change the form max-height and respect the CSS transition
	$(window).resize(function () {
		if ($(window).outerWidth() > 990) {
			updateMaxListHeight();
		}
	});

	// Hide/Show the form
	$("#summaryHider").on("click", function () {
		$("#summaryList").toggleClass("hidden");
		$(this).toggleClass("isHiding");
	});

	// In case there are already products in the list...
	let summaryElements = $(".summaryElement");
	summaryElements.each(function () {
		if ($(window).outerWidth() > 990) {
			// ...set their max size
			setMaxWidth(this);
			setMaxHeight(this);
			
			// ..add a fade-in animation
			addAnimation(summaryElements);
		}

		// ..advice the user when hovering the X
		addAdviceEvent(summaryElements);
		// ..destroy the product when the X is clicked
		addDestroyEvent(summaryElements);
		// ..make incremental/decremental buttons work
		bindButtons(this);
	});
	// ..check if there are no products in the cart
	updateCheckoutBtn();
	// ..set the counter to the appropriate value
	updateCounter();

	// Get initial form max-height
	if ($(window).outerWidth() > 990) {
		updateMaxListHeight();
	}

	$("#cancelSummary").on("click", function () {
		let summaryElements = $(".summaryElement");
		summaryElements.each(function () {
			explodeProduct(this);
		});
	});
});

// Sets the max-width for a product
function setMaxWidth(product) {
	$(product).css("--max-w", $(product).width() + "px");
}

// Sets the max-height for a product
function setMaxHeight(product) {
	$(product).css("--max-h", $(product).height() + "px");
}

// Adds the product to the summary list
function addProduct(product) {
	$("#summCheckout").before(product);

	if ($(window).outerWidth() > 990) {
		// Set their max size
		setMaxWidth(product);
		setMaxHeight(product);

		// ..add a fade-in animation
		addAnimation(product);
	}

	// ..advice the user when hovering the X
	addAdviceEvent(product);
	// Destroy the product when the X is clicked
	addDestroyEvent(product);
	// Make incremental/decremental buttons work
	bindButtons(product);

	// Various checks after adding it
	updateCheckoutBtn();
	updateCounter();
}

// Destroys the product from the summary list, and uncheck it if visible in the list
function explodeProduct(product) {
	// Prepare deletion
	let e = $(product);

	// Remove previous startup animation
	e.css("animation", "");

	// Disable all children inputs
	e.find("input").prop("disabled", true);

	// Uncheck the corresponding checkbox in the product list
	uncheck($(product).find("input[type='hidden']").val());
	
	// Remove hidden value
	e.find('input[type="hidden"]').remove();

	if ($(window).outerWidth() > 990) {
		e.addClass("deleted").delay(700).queue(function () {
			// Delete element
			$(this).remove();

			// Update form's max-height
			updateMaxListHeight();
		});

		// Decrease the counter
		updateCounter();

		// Check if there are no products in the cart
		updateCheckoutBtn();

		return;
	}

	// If it's from mobile, do a quicker version

	$(product).remove();

	// Decrease the counter
	updateCounter();

	// Check if there are no products in the cart
	updateCheckoutBtn();
}

function updateMaxListHeight() {
	// If the user is resizing
	let resizing = $("#summaryList")[0].scrollHeight !== $("#summaryList").height();

	// Check if the element was resized. If it was, don't animate the resizing
	if (resizing) $("#summaryList").removeClass("notResizing");

	// Set the new max size for the expanding/hiding animation
	$("#summaryList").css("--max", ($("#summaryList")[0].scrollHeight + 200) + "px");

	// Delay "hack"
	$("#summaryList")[0].offsetWidth;

	// Finished resizing
	if (resizing) $("#summaryList").addClass("notResizing");

	// Set new previous size
	prevSize = $("#summaryList")[0].scrollHeight;
}

function updateCheckoutBtn() {
	if ($("#summaryList .summaryElement:not(.deleted)").length === 0) {
		$("#summCheckout input").prop("disabled", true);
	} else {
		$("#summCheckout input").prop("disabled", false);
	}
}

function addDestroyEvent(productPreview) {
	$(productPreview).find(".summPreview").on("click", function () {
		let product = $(this).closest(".summaryElement");
		explodeProduct(product);
	})
}

function addAdviceEvent(product) {
	let preview = $(product).find(".summPreview");
	$(preview).mouseenter(function () {
		$(this).closest(".summaryElement").addClass("deleting");
	});
	$(preview).mouseleave(function () {
		$(this).closest(".summaryElement").removeClass("deleting");
	});
}

function addAnimation(product) {
	$(product).css("animation", "slide-in-card 700ms ease");
}

function updateCounter() {
	let value = $(".summaryElement:not(.deleted)").length;

	$(".summCount").text(value);
}

function bindButtons(product) {
	let numberBox = $(product).find(".summNumber");
	let number = $(product).find(".productNumber");

	// Bind the incremental/decremental
	$($(numberBox).find("button")[0]).on("click", function () {
		let newVal = +$(number).val() - 1;

		if (newVal <= 0) return;

		$(number).val(newVal);
	});

	$($(numberBox).find("button")[1]).on("click", function () {
		let newVal = +$(number).val() + 1;

		// if (newVal >= ???) return; TODO: check for max?

		$(number).val(newVal);
	});
}

function isProductAlreadyPresent(checkbox_id) {
	return $(`#summaryList .summaryElement:not(.deleted) input[type="hidden"][value="${checkbox_id}"]`).length > 0;
}