<?php
@define('DOCUMENT_ROOT', '/membri/gabrieldn5j');

$pages = ['contact', 'maps'];

$head_attributes = ['<link rel="stylesheet" href="/css/contact.css">'];

include DOCUMENT_ROOT . '/common/header.php';

?>

<body>
	<?php include DOCUMENT_ROOT . '/common/navbar.php'; ?>

	<div id="mainBody">
		<div id="mainBodyHeader"><?php echo $language['contact']['title']; ?></div>

		<div class="contact-body">
			<div class="mapContainer">
				<div id="locationMap"></div>
			</div>

			<?php include DOCUMENT_ROOT . '/common/contact-info.php'; ?>
		</div>

		<script src="/js/contact.js"></script>
	</div>

	<?php include DOCUMENT_ROOT . '/common/footer.php'; ?>
	<?php
	$region = $language['maps']['region'];
	$lang = $language['maps']['language'];
	echo "<script src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyB-fudbUI-g5u9LPefblJSQrMjEKtdeTZ0&region=$region&language=$lang&map_ids=f36bdaee4314cae0&callback=initMap\"></script>";
	?>
</body>

</html>