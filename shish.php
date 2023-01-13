<?php
@define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

$pages = ['shish'];

$head_attributes = [
	'<link rel="stylesheet" href="/css/home.css">',
	'<style>
		#mainBody {
			display: flex;
			justify-content: center;
		}
		#ytplayer {
			flex-basis: 95%;
			width: 85%;
			flex-grow: 0;
			min-height: calc(100vh - 120px - 50px);
			height: auto;
			margin: 20px 0 0 0;
			border-radius: 25px;
		}
	</style>'
];

include DOCUMENT_ROOT . '/common/header.php';

?>

<body>
	<?php include DOCUMENT_ROOT . '/common/navbar.php'; ?>

	<div id="mainBody">
		<iframe id="ytplayer" type="text/html" width="1920" height="1080" src="https://www.youtube-nocookie.com/embed/P6uexhFGT4I?rel=0&autoplay=1&iv_load_policy=3&controls=0&vq=hd1080&modestbranding=1<?php if (isset($language['head']['html_lang'])) echo '&hl=' . $language['head']['html_lang']; ?>" title="Shish" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope" allowfullscreen></iframe>
	</div>

	<?php include DOCUMENT_ROOT . '/common/footer.php'; ?>
</body>

</html>