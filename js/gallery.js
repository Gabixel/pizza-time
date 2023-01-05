let imageList = [];
let currentIndex = 0;

$(function () {
	let imageGallery = $("#image-gallery")
	let images = $(imageGallery).find(".gallery-image-container>.gallery-image");
	imagesNumber = images.length;

	// Store images in an array
	storeImages(images);
	// Gives click event to each image of the gellary
	prepareImagesEvents(images);

	// Click event for the carousel's "close" icon
	$("#galleryPreview>.previewHeader>.previewClose").click(hidePreview);

	// Gives some shortcuts to the carousel
	$(document).on("keydown", function (e) {
		if ($("#galleryPreview").is(".visible")) {
			// Escape (close)
			if (e.key == "Escape") {
				e.preventDefault();
				hidePreview();
				return;
			}

			// Arrows (scroll)
			switch (e.which) {
				case 37: // left & up
				case 38:
					e.preventDefault();
					scrollPreview(-1);
					return;

				case 39: // right & down
				case 40:
					e.preventDefault();
					scrollPreview(1);
					return;
			}
		}
	});

	// Gives the click event to the scroll buttons
	let scrollLeft = $("#galleryPreview .scrollLeft"),
		scrollRight = $("#galleryPreview .scrollRight");

	scrollLeft.click(function () {
		scrollPreview(-1);
	});
	scrollRight.click(function () {
		scrollPreview(1);
	});

});

function storeImages(images) {
	$(images).each((index, element) => {
		imageList.push(getImagePath(element));
		$(element).data("index", index);
	});
}

function getImagePath(cssProp) {
	return $(cssProp).attr("style").replace("--img: url('", '').replace("');", '');
}

function prepareImagesEvents(images) {
	$(images).each(function () {
		addImageClickEvent(this);
	});
}

function addImageClickEvent(image) {
	$(image).on("click", function () {
		showCarousel($(this).data("index"));
	});
}

function showCarousel(index) {
	preparePreviewForImage(index);
	showPreview();
}

function preparePreviewForImage(index) {
	setPreviewTitle(index);
	setCurrentIndex(index);
	showCurrentIndex(index);
	refreshArrows();
	showImage(index);
}

function setPreviewTitle(index) {
	let title = $("#galleryPreview>.previewHeader>.previewTitle>.previewTitleText");
	title.text(getImageName(imageList[index]));
}

function showCurrentIndex() {
	let imageCounter = $("#galleryPreview .imageCounter");
	let currentImage = currentIndex + 1;
	let lastImage = imageList.length;
	imageCounter.text(currentImage + " / " + lastImage);
}

function getImageName(imagePath) {
	let lastSlash = imagePath.lastIndexOf("/");

	return imagePath.substr(lastSlash + 1);
}

function showImage(index) {
	let image = $("#galleryPreview .carouselImage");

	image.attr("src", imageList[index]);
	image.attr("alt", imageList[index]);
}

function showPreview() {
	let preview = $("#galleryPreview");
	$(preview).addClass("visible");
}

function hidePreview() {
	let preview = $("#galleryPreview");
	$(preview).removeClass("visible");
}

function setCurrentIndex(index) {
	currentIndex = index;
}

function scrollPreview(number) {
	let newIndex = currentIndex + number;

	if (newIndex >= 0 && newIndex <= imageList.length - 1)
		preparePreviewForImage(newIndex);
}

function refreshArrows() {
	let scrollLeft = $("#galleryPreview .scrollLeft"),
		scrollRight = $("#galleryPreview .scrollRight");

	let blockClass = "endScroll";

	if (currentIndex > 0)
		$(scrollLeft).removeClass(blockClass);
	else
		$(scrollLeft).addClass(blockClass);

	if (currentIndex < imageList.length - 1)
		$(scrollRight).removeClass(blockClass);
	else
		$(scrollRight).addClass(blockClass);
}