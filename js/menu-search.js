let searchTimeout = 1000,
	searchTimer,
	searchBar,
	lastSearch = "";

var productTranslation;

$(function () {
	searchBar = $("#searchBar");

	getTranslationAsync();

	// When the user changes the input
	// This event should handle every possible combination of inputs
	searchBar.on("input propertychange paste cut", function () {
		$("#menuProductsList").addClass("searching");

		clearTimeout(searchTimer);
		// Start the timer for the search
		searchTimer = setTimeout(function () {
			let currentSearch = searchBar.val();
			currentSearch = currentSearch.trim();

			if (currentSearch.length >= 255) return removeSearching();

			// If the search is empty
			if (!currentSearch) {
				// If the last search contains text
				if (!lastSearch) return removeSearching();
			} else if (currentSearch == lastSearch) return removeSearching();

			// If every key is up
			getProductsListAsync(currentSearch);
			$(this).delay(50).queue(function () {
				removeSearching();

				$(this).dequeue();
			});
		}, searchTimeout);

		// Show/Hide the clear button
		let btn = "div.cancelSearch";

		if ($(this).val() != "") {
			$(btn).addClass("visible");
		} else {
			$(btn).removeClass("visible");
		}
	});

	searchBar.on("focusin", function () {
		$("#searchForm").addClass("focused");
	});
	searchBar.on("focusout", function () {
		$("#searchForm").removeClass("focused");
	});

	// When the user types something while scrolling, scroll to the navbar (+ navbar offset)
	// source: https://stackoverflow.com/questions/21539553/move-input-with-focus-out-from-under-fixed-header-or-fixed-footer
	searchBar.on("input", function () {
		let offset = 70 + 30; /* 70 navbar, 30 random offset before navbar*/

		if (($(this).offset().top - 70) < window.scrollY)
			$('html, body').animate({
				scrollTop: $(this).offset().top - offset
			}, 600);
	});

	// Focus the search bar
	focusSearchBar(searchBar);

	// Add the click event for the clear button and trigger the input's input event
	$("div.cancelSearch").on("click", function () {
		searchBar.val("");
		searchBar.trigger("input");
		focusSearchBar(searchBar);
		$(this).removeClass("visible");
	});

});

function removeSearching() {
	$("#menuProductsList").removeClass("searching");
}

function focusSearchBar(searchBar) {
	let x = window.scrollX,
		y = window.scrollY;

	$(searchBar)[0].focus({
		preventScroll: true
	});

	window.scrollTo(x, y);
}

async function getProductsListAsync(string) {
	let query;

	query = string;

	lastSearch = query;

	// Query search (POST)
	let request = {
		"type": "search",
		"search": query,
	};

	let response;

	try {
		// Get the product list
		response = await requestSearchAsync(request);
		response = JSON.parse(response);
	} catch (e) {
		console.error(e);
		return;
	}

	// Re-create the product list
	regenerateList(response);
	$(".product:not(.unavailable) .productPreview").click(() => checkBoxClicked = true);
	$(".product:not(.unavailable)").click(toggleExpand);
}

async function getTranslationAsync() {
	let request = {
		"type": "translation",
	};

	try {
		// Get the translation
		productTranslation = await requestSearchAsync(request);
		productTranslation = JSON.parse(productTranslation);
	} catch (e) {
		console.error(e);
		return '';
	}
}

async function requestSearchAsync(args) {
	let response;

	await $.ajax({
		url: "/common/product-search.php",
		type: 'POST',
		data: args,
		timeout: 2000, // 2 seconds of timeout
	}).done((data) => response = data).fail();

	return response;
}

function regenerateList(response) {
	let productList = $("#menuProductsList");

	// Clear the product list
	productList.empty();

	// Create card for each product and append it
	(response.products).forEach(currentProduct => {
		let currentId = +currentProduct.id;

		let product = {
			id: currentId,
			idType: +currentProduct.id_type,
			iconType: currentProduct.iconType,
			isUserLoggedIn: response.user.is_logged_in,
			isAvailable: +currentProduct.is_available === 1 ? true : false,
			isFrozen: +currentProduct.frozen === 1 ? true : false,
			image: currentProduct.image,
			priceTotal: currentProduct.price,
			ingredientsNormal: currentProduct.ingredients_normal,
			ingredientsPostCooking: currentProduct.ingredients_post_cooking,
			description: productTranslation.products.description[currentId],
			isSelected: isProductAlreadyPresent(currentId),
		}

		let card = createCard(product);

		productList.append(card);
	});

	if (productList.children().length > 0) return;

	// If the list is empty
	let emptyList = ProductCard.createEmptyList();
	productList.append(emptyList);
}

function createCard(p) {
	let generator = new ProductCard(productTranslation);

	// Main card
	let card = $(`<div class="product${(!p.isAvailable ? " unavailable" : "")}" />`);

	// Preview (checkbox, image, etc.)
	card.append(generator.getPreview(p.id, p.isAvailable, p.image, p.isUserLoggedIn, p.isSelected));

	card.append(generator.getTitle(p.id, p.iconType, p.idType, p.isFrozen));

	let price = generator.getPriceFormatted(p.priceTotal);
	card.append(generator.getPriceSmall(price));

	card.append(generator.getDescription(p.ingredientsNormal, p.ingredientsPostCooking, p.description));

	card.append("<hr />");

	card.append(generator.getExtraInfo(p.ingredientsPostCooking, price));

	if (!p.isAvailable) card.append(generator.getUnavailableStatus());

	return card;
}

class ProductCard {
	constructor(translation) {
		this.translation = translation;
	}

	getPreview(id, isAvailable, image, isUserLoggedIn, isSelected) {
		let preview = $("<div class=\"productPreview\" />");

		let checkbox = `<input type="checkbox" value="${id}" class="productCheckBox"`;
		if (!isUserLoggedIn || !isAvailable) checkbox += " disabled";
		if (isSelected) checkbox += " checked";
		checkbox += " />";

		preview.append(checkbox);
		preview.append(`<div class="productImage" style="--img: url('${image}')" />`);

		let checkboxMessage = this.translation.products.checkbox;
		let message = $('<p />').append(isUserLoggedIn ? checkboxMessage.user : checkboxMessage.guest);
		preview.append(message);

		return preview;
	}

	getTitle(idTitle, iconType, idType, isFrozen) {
		let title = $('<div class="productTitle" />');
		title.append(this.getFullTitle(idTitle, iconType, idType));

		if (isFrozen) title.append(`<i class="far fa-snowflake" title="${productTranslation.products.frozen}" />`);

		return title;
	}

	getFullTitle(idTitle, iconType, idType) {
		let titleString = productTranslation.products.title[idTitle];

		let fullTitle = $('<div class="productFullTitle" />');

		let spanTitle = $(`<span title="${titleString}" />`);
		spanTitle.append(this.getProductTypeIcon(iconType, idType));
		spanTitle.append($("<span />").text(titleString));

		fullTitle.append(spanTitle);

		return fullTitle;
	}

	getProductTypeIcon(iconType, idType) {
		let icon = $(`<img src="${iconType}" />`);

		let typeName = productTranslation.products.type[idType];
		if (typeName) {
			icon.attr("alt", typeName);
			icon.attr("title", typeName);
		}

		return icon;
	}

	getPriceFormatted(priceTotal) {
		let integer = Math.floor(priceTotal),
			decimalsPosition = priceTotal.indexOf('.') + 1,
			decimals = priceTotal.substring(decimalsPosition);

		if (Math.floor(+decimals / 10) === 0.0)
			decimals = String(decimals * 10);

		let priceFormatted = "€ " + integer + productTranslation.price.decimals_separator + decimals.padStart(2, "0");

		return priceFormatted;
	}

	getPriceSmall(priceTotal) {
		let priceSmall = $('<div class="productPriceSmall" />').append($("<span />").text(priceTotal));

		return priceSmall;
	}

	getDescription(ingredientsNormal, ingredientsPostCooking, description) {
		let finalDescription = $('<div class="productDescription" />');

		if (!ingredientsNormal && !ingredientsPostCooking && !description)
			return "";

		if (description) {
			finalDescription.append($('<p class="alternative" />').text(description));
			return finalDescription;
		}

		// If there's no custom description
		finalDescription.append($("<p />").html(this.getIngredients(ingredientsNormal, ingredientsPostCooking)));

		return finalDescription;
	}

	getIngredients(ingredientsNormal, ingredientsPostCooking) {
		let totalPostCooking =
			ingredientsPostCooking ?
			ingredientsPostCooking.length :
			0;

		let ingredients = "";

		// If there are normal ingredients
		if (ingredientsNormal && ingredientsNormal.length > 0) {
			let normal = this.getIngredientsNormal(ingredientsNormal, totalPostCooking);

			if (!normal) return ""; // Return no description if a translation fails

			ingredients += normal;

		} else ingredientsNormal = false;

		// If there are post-cooking ingredients
		if (totalPostCooking > 0) {
			let postCooking = this.getIngredientsPostCooking(ingredientsNormal, totalPostCooking, ingredientsPostCooking);

			if (!postCooking) return "";

			ingredients += postCooking;
		}

		return ingredients;
	}

	getIngredientsNormal(ingredientsNormal, totalPostCooking) {
		let ingredients = "",
			totalNormal = ingredientsNormal.length;

		for (let i = 0; i < totalNormal; i++) {
			let ingredientTranslation = productTranslation.ingredients[ingredientsNormal[i]];

			if (!ingredientTranslation) {
				return false; // If a translation fails, tell to show nothing
			}

			if (i > 0) {
				if (((i + 1) == totalNormal) && totalPostCooking === 0) {
					ingredients += " " + productTranslation.ingredients.separator;
				} else {
					ingredients += ",";
				}

				ingredients += " ";
			}

			ingredients += ingredientTranslation;
		}

		return ingredients;
	}

	getIngredientsPostCooking(ingredientsNormal, totalPostCooking, ingredientsPostCooking) {
		let ingredients = "";

		if (ingredientsNormal && totalPostCooking == 1) {
			ingredients += " " + productTranslation.ingredients.separator + " ";
		}

		for (let i = 0; i < totalPostCooking; i++) {
			let ingredientTranslation = productTranslation.ingredients[ingredientsPostCooking[i]];

			if (!ingredientTranslation) {
				return false;
			}

			if (i > 0) {
				if ((i + 1) == totalPostCooking) {
					ingredients += " " + productTranslation.ingredients.separator;
				} else {
					ingredients += ",";
				}

				ingredients += " ";
			}

			ingredients += `<span class="postCooking">${ingredientTranslation}</span>`;
		}

		return ingredients;
	}

	getExtraInfo(ingredientsPostCooking, priceTotal) {
		let extra = $('<div class="infoExtra" />');

		// Post-cook advice
		if (ingredientsPostCooking && ingredientsPostCooking.length > 0) {
			extra.append('<i class="fas fa-info-circle" />');
			extra.append($('<span class="infoCook" />').html(productTranslation.products.post_cook));
		}

		// Price (big version)
		let bigPrice = $('<span class="productPrice" />');
		bigPrice.html(priceTotal);
		extra.append(bigPrice);

		return extra;
	}

	getUnavailableStatus() {
		let soldOut = $('<div class="productSoldOut" />');
		soldOut.append($('<span class="soldOutText" />').text(productTranslation.products.unavailable));

		return soldOut;
	}

	// When the search returns nothing
	static createEmptyList() {
		let emptyMessage = $('<div id="emptyResultContainer" />');
		emptyMessage.append('<div class="resultImage" />');
		emptyMessage.append($('<div class="resultMessage" />').text(productTranslation.search.empty));

		return emptyMessage;
	}
}