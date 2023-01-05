<?php
@define('DOCUMENT_ROOT', '/membri/gabrieldn5j');

require_once DOCUMENT_ROOT . '/common/gallery.php';

$pages = ['gallery'];
$head_attributes = [
	'<script src="/js/gallery.js"></script>',
	'<link rel="stylesheet" href="/css/gallery.css">',
];

include DOCUMENT_ROOT . '/common/header.php';

$img_dir = '/img/gallery/';
?>

<body>
	<?php include DOCUMENT_ROOT . '/common/navbar.php'; ?>

	<div id="mainBody">
		<div id="mainBodyHeader"><?php echo $language['gallery']['title']; ?></div>

		<div id="image-gallery"><?php echo ImageGallery::generate_gallery($img_dir); ?>
		</div>

		<div id="galleryPreview" tabindex="1">
			<div class="previewHeader">
				<div class="previewTitle">
					<span class="info-icon"><i class="fas fa-info-circle"></i></span>
					<span class="previewTitleText"></span>
				</div>
				<div class="previewClose">
					<i class="fas fa-times"></i>
				</div>
			</div>
			<div class="previewCarousel">
				<div class="scrollLeft endScroll"><i class="fas fa-chevron-left"></i></div>
				<div class="carouselImageContainer"><img class="carouselImage"></div>
				<div class="scrollRight endScroll"><i class="fas fa-chevron-right"></i></div>
			</div>
			<div class="imageCounter">-</div>
		</div>
	</div>

	<?php include DOCUMENT_ROOT . '/common/footer.php'; ?>
</body>

</html>