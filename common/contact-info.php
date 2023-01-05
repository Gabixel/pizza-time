<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}
?>
<div class="contact-info">
	<ul class="fa-ul">
		<li><span class="fa-li"><i class="fas fa-map-marker"></i></span>
			<?php echo $language['contact']['content']['location']; ?> <a href="https://www.google.com/maps/place/MONDOPIZZA+DA+ALE/@43.9361804,12.6571249,151m/data=!3m1!1e3!4m13!1m7!3m6!1s0x132ce666423a9c29:0x8b337c3ec436033!2sVia+Francesco+Petrarca,+80,+47832+San+Clemente+RN!3b1!8m2!3d43.9362171!4d12.6575971!3m4!1s0x132ce66ae785f40b:0x5f82e2e70759f92f!8m2!3d43.935959!4d12.6574972" target="_blank" rel="noreferrer">Sant'Andrea in Casale (RN)</a>
		</li>
		<li><span class="fa-li"><i class="fas fa-clock"></i></span>
			<?php echo $language['contact']['content']['time']; ?>
		</li>
		<li><span class="fa-li"><i class="fas fa-phone"></i></span>
			<?php echo $language['contact']['content']['phone']; ?> <a href="tel:0541865019">0541-865019</a>
		</li>
		<li><span class="fa-li"><i class="fas fa-envelope"></i></span>
			<?php echo $language['contact']['content']['mail']; ?> <abbr title="<?php echo $language['contact']['content']['fake']; ?>"><a href="mailto:pizzatime@gmail.com">pizzatime@gmail.com</a></abbr>
		</li>
	</ul>
</div>