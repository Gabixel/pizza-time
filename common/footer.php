<?php
// If the file is called directly and not included
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
	header('Location: /');
}
?><footer>
	<div class="socials">
		<a href="https://twitter.com/" target="_blank" rel="noreferrer" class="twitter"><i class="fab fa-twitter"></i></a>
		<a href="https://www.facebook.com/" target="_blank" rel="noreferrer" class="facebook"><i class="fab fa-facebook"></i></a>
		<a href="https://www.instagram.com/" target="_blank" rel="noreferrer" class="instagram"><i class="fab fa-instagram"></i></a>
	</div>
	<div class="about">
		<a href="/about">
			<div class="about-icon">
				<i class="fas fa-graduation-cap"></i>
			</div>
			<span><?php echo $language['footer']['about_message']; ?></span>
		</a>
	</div>
</footer>