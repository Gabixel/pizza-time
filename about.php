<?php
@define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);

$pages = ['about'];

$head_attributes = [
	'<link rel="stylesheet" href="/css/about.css">',
	'<script src="/js/about.js"></script>'
];

include DOCUMENT_ROOT . '/common/header.php';

function generate_link($url, $text, $logo_url, $color, $text_color = '#fff')
{
	echo "<a href=\"$url\" class=\"link-card\" target=\"_blank\" rel=\"noreferrer\" style=\"--color: $color; --text: $text_color\"><div class=\"logo\" style=\"--logo: url('/img/brands/$logo_url.svg');\"></div><span>$text</span><i class=\"fas fa-chevron-right\"></i></a>";
}

?>

<body>
	<?php include DOCUMENT_ROOT . '/common/navbar.php'; ?>

	<div id="mainBody">
		<div id="mainBodyHeader"><?php echo $language['about']['title']; ?></div>

		<div id="siteSummary">
			<div id="content1">
				<div class="school-image-container">
					<div class="school-image"></div>
				</div>

				<p><i class="fas fa-laptop-code about-icon"></i><?php echo $language['about']['content'][1]; ?></p>
				<p><?php echo $language['about']['content'][2]; ?></p>
			</div>

			<hr />

			<div id="content2">
				<div class="profile-image-container">
					<div class="profile-image">
						<div class="shadow-container"></div>
					</div>
				</div>

				<div class="text">
					<p><i class="fas fa-quote-left about-icon"></i><?php echo $language['about']['content'][3]['title']; ?></p>
					<p><?php echo $language['about']['content'][3]['description']; ?></p>
				</div>
			</div>

			<hr />

			<div id="content3">
				<p><i class="fas fa-stopwatch about-icon"></i><?php echo $language['about']['content'][4]; ?></p>
				<p class="timer">197</p>
			</div>

			<hr />

			<div id="content4">
				<p><i class="fas fa-link about-icon"></i><?php echo $language['about']['content'][5]['title']; ?></p>
				<?php
				generate_link('https://www.linkedin.com/in/gabdn/', 'LinkedIn', 'linkedin', '#0e76a8');
				generate_link('https://www.twitch.tv/gabixel', 'Twitch', 'twitch', '#6441a5');
				generate_link('https://steamcommunity.com/id/Gabixel', 'Steam', 'steam', '#1b2838');
				generate_link('https://github.com/Gabixel', 'GitHub', 'github', '#6a737d');
				generate_link('https://twitter.com/Gabixel_', 'Twitter', 'twitter', '#1a76cc');
				generate_link('https://osu.ppy.sh/users/8543042', 'osu!', 'osu', '#f560ae');
				?>
			</div>
		</div>

		<a href="/shish" class="shish"></a>
	</div>

	<?php include DOCUMENT_ROOT . '/common/footer.php'; ?>
</body>

</html>