<?php
@define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

$pages = ['home'];

$head_attributes = ['<link rel="stylesheet" href="/css/home.css">'];

include DOCUMENT_ROOT . '/common/header.php';

$cards = $language['home']['content']['cards'];
?>

<body>
	<?php include DOCUMENT_ROOT . '/common/navbar.php'; ?>

	<div id="mainBody">
		<div id="mainBodyHeader"><?php echo $language['home']['title']; ?></div>
		<p class="center">
			<?php echo $language['home']['content']['summary']; ?> <a href="https://www.google.com/maps/place/MONDOPIZZA+DA+ALE/@43.9361804,12.6571249,151m/data=!3m1!1e3!4m13!1m7!3m6!1s0x132ce666423a9c29:0x8b337c3ec436033!2sVia+Francesco+Petrarca,+80,+47832+San+Clemente+RN!3b1!8m2!3d43.9362171!4d12.6575971!3m4!1s0x132ce66ae785f40b:0x5f82e2e70759f92f!8m2!3d43.935959!4d12.6574972" target="_blank" rel="noreferrer">Sant'Andrea in Casale (RN)</a>.
		</p>
		<hr>
		<section class="cards-list">
			<div class="info-card large">
				<div class="card-image">
					<div class="image"></div>
					<div class="shadow"></div>
				</div>
				<div class="card-description">
					<span><i class="fas fa-pizza-slice"></i><?php echo $cards['menu']['summary']; ?><i class="fas fa-utensils"></i></span>
					<hr>
					<span class="explore"><a href="/menu"><?php echo $cards['menu']['details']; ?><i class="fas fa-arrow-circle-right"></i></a></span>
				</div>
			</div>
			<div class="info-card">
				<div class="card-image">
					<div class="image"></div>
					<div class="shadow"></div>
				</div>
				<div class="card-description"><span><?php echo $cards['orders']; ?></span></div>
			</div>
			<div class="info-card">
				<div class="card-image">
					<div class="image"></div>
					<div class="shadow"></div>
				</div>
				<div class="card-description"><span><?php echo $cards['hours']; ?></span></div>
			</div>
		</section>
	</div>

	<?php include DOCUMENT_ROOT . '/common/footer.php'; ?>
</body>

</html>