let checkBoxClicked = false;

$(function () {
	// Not sure if these are race conditions
	$(".product:not(.unavailable) .productPreview").click(() => checkBoxClicked = true);
	$(".product:not(.unavailable)").click(toggleExpand);
});

function toggleExpand() {
	// If the user clicked the blank space in a product card
	if (!checkBoxClicked) {
		$(".product.expanded:not(:focus)").not(this).removeClass("expanded");

		if ($(window).outerWidth() > 990)
			$(this).toggleClass("expanded");
			
		return;
	}

	// Checkbox clicked
	checkBoxClicked = false;

	let checkbox = $(this).find(".productPreview input[type='checkbox']");

	// If the click checked the checkbox
	let checked = $(checkbox).prop("checked");

	// If there's already the product
	let isAlreadyAdded = isProductAlreadyPresent($(checkbox).val());
	// If it's out of stock
	let isOutOfStock = $(this).find(".productPreview input[type='checkbox'][disabled]").length > 0;

	// Check if there are issues before adding/removing
	if (checked) {
		if (!isAlreadyAdded && !isOutOfStock) addToSummary(this);
	} else removeFromSummary($(checkbox));
}

function addToSummary(product) {
	product = createProductSummaryCard(product);
	addProduct(product);
}

function removeFromSummary(productCheckbox) {
	$("#summaryList input[type='hidden']").each(function () {
		// If the product is present
		if ($(this).val() == $(productCheckbox).val()) {
			// Product found, removing...
			explodeProduct($(this).closest(".summaryElement"));
			return;
		}
	});
}

function uncheck(productID) {
	// Uncheck the checkbox (if checked and visible)
	let checkbox = $(".productPreview input[type='checkbox'][value='" + productID + "']:checked");
	checkbox.prop("checked", false);
}

function check(productID) {
	// Check the checkbox (e.g. after a search)
	let checkbox = $(".productPreview input[type='checkbox'][value='" + productID + "']");
	checkbox.prop("checked", true);
}

function createProductSummaryCard(product) {
	// Info
	let productID = $(product).find(".productPreview input[type='checkbox']").val();
	let imageUrl = $(product).find(".productImage").css("--img");
	let typeUrl = $(product).find("img").prop("src");
	let title = $(product).find("span[title] span").text();

	// Container
	let element = $('<div class="summaryElement" />');
	let card = element;

	// Hidden ID input
	element = $('<input type="hidden" name="productID[]" value="' + productID + '" />');
	card.append(element);

	// Preview (image + delete icon)
	element = $('<div class="summPreview" />');
	element.append('<div class="summImage" style=\'--img:' + imageUrl + '\' />')
	element.append('<div class="summBtnRemove"><i class="fas fa-times"></i></div>');
	card.append(element);

	// Title
	element = $('<div class="summTitle" />');
	let titleElements = $('<span />');
	titleElements.append('<img src="' + typeUrl + '" />');
	titleElements.append('<span>' + title + '</span>');
	element.append(titleElements);
	card.append(element);

	// Buttons (+ counter)
	element = $('<div class="summNumber" />');
	let button1 = $('<button type="button" class="btnDecrement"><i class="fas fa-minus"></i></button>');
	let input = $('<input type="number" name="productNumber[]" class="productNumber" min="1" value="1" required />');
	let button2 = $('<button type="button" class="btnIncrement"><i class="fas fa-plus"></i></button>');
	element.append(button1, input, button2);
	card.append(element);

	return card;
}